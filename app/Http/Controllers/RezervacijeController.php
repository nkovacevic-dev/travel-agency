<?php

namespace App\Http\Controllers;

use App\Enums\StatusRezervacije;
use App\Http\Requests\StoreRezervacijaRequest;
use App\Http\Requests\UpdateRezervacijaRequest;
use App\Models\Drzava;
use App\Models\Hotel;
use App\Models\Putovanje;
use App\Models\Rezervacija;
use App\Models\Termin;
use App\Models\TipSobe;
use App\Services\RezervacijaService;
use App\Support\SelectOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RezervacijeController extends Controller
{
    public function __construct(private RezervacijaService $service) {}

    private function getDropdownData(): array
    {
        return [
            'putovanja' => SelectOptions::odNaziva(Putovanje::all()),
            'tip_sobe'  => SelectOptions::odNaziva(TipSobe::all()),
            'drzave'    => SelectOptions::odNaziva(Drzava::orderBy('naziv')->get()),
        ];
    }
    /**
     * Display a listing of the resource (admin).
     */
    public function index()
    {
        return view('rezervacije.lista');
    }

    /**
     * DataTable za rezervacije (admin).
     */
    public function tabela()
    {
        $query = Rezervacija::select(
                'rezervacija.*',
                'putovanje.naziv as naziv_putovanja',
                'termini.datum_od',
                'termini.datum_do'
            )
            ->leftJoin('putovanje', 'putovanje.id', '=', 'rezervacija.id_putovanja')
            ->leftJoin('termini', 'termini.id', '=', 'rezervacija.id_termina')
            ->orderBy('rezervacija.created_at', 'desc');

        return datatables()->of($query)
            ->addColumn('akcija', 'rezervacije.dt.kolona_akcije')
            ->addColumn('termin', 'rezervacije.dt.kolona_termin')
            ->rawColumns(['akcija', 'termin'])
            ->make(true);
    }

    public function create()
    {
        $rezervacija = new Rezervacija();
        $termini = [];
        $hoteli  = [];
        return view('rezervacije.forma', array_merge(
            ['rezervacija' => $rezervacija, 'termini' => $termini, 'hoteli' => $hoteli],
            $this->getDropdownData()
        ));
    }
    public function store(StoreRezervacijaRequest $request)
    {
        try {
            DB::beginTransaction();

            $brojOdraslih = (int) $request->broj_odraslih;
            $brojDece     = (int) $request->broj_dece;
            $this->service->proveriBrojPutnika($brojOdraslih, $brojDece);

            $termin = Termin::findOrFail($request->id_termina);
            $this->service->proveriMinDanaPrePolaska($termin);
            $this->service->proveriDostupnaMesta($termin, $brojOdraslih + $brojDece);

            // Izračunaj ukupnu cenu
            $putovanje = Putovanje::findOrFail($request->id_putovanja);
            $ukupna_cena = $this->service->izracunajCenu($putovanje, $request->broj_odraslih, (int) $request->broj_dece);
            
            $data = $request->all();
            $data['ukupna_cena'] = $ukupna_cena;
            $data['status'] = StatusRezervacije::Nova;
            
            $rezervacija = Rezervacija::create($data);
            
            // Ažuriraj broj rezervacija za putovanje i preostala mesta za termin
            $putovanje->increment('broj_rezervacija');
            $termin->decrement('broj_dostupnih_mesta', $brojOdraslih + $brojDece);
            
            DB::commit();

            try {
                $this->service->posaljiEmailPotvrde($rezervacija);
            } catch (\Exception $e) {
                // Log error ali ne prekidaj proces
                Log::error('Greška pri slanju email-a: ' . $e->getMessage());
            }

            // Ako je admin, vrati na listu, ako je javno, vrati poruku uspešnosti
            if (Auth::check()) {
                return redirect()->route('rezervacije.index')->with('success', 'Rezervacija je uspešno kreirana!');
            } else {
                return redirect()->route('putovanja.show', $request->id_putovanja)
                    ->with('success', 'Vaša rezervacija je uspešno primljena! Potvrda je poslata na Vaš email.');
            }
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Greška pri rezervaciji: ' . $e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());

            if (Auth::check()) {
                return redirect()->route('rezervacije.create')->withInput()->with('fail', $e->getMessage());
            } else {
                return back()->withInput()->with('fail', $e->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rezervacija = Rezervacija::with(['putovanje', 'hotel', 'tipSobe'])->findOrFail($id);
        return view('rezervacije.prikaz', compact('rezervacija'));
    }

    public function edit(string $id)
    {
        $rezervacija = Rezervacija::findOrFail($id);

        $termini = [];
        $hoteli  = [];
        if ($rezervacija->id_putovanja) {
            $putovanje = Putovanje::with('termini')->find($rezervacija->id_putovanja);
            if ($putovanje) {
                $termini = $putovanje->termini->map(fn($t) => [
                    'id'   => $t->id,
                    'text' => $t->datum_od->format('d.m.Y.') . ' – ' . $t->datum_do->format('d.m.Y.'),
                ])->toArray();
                $hoteli = SelectOptions::odNaziva(Hotel::where('id_drzave', $putovanje->id_drzave)->get());
            }
        }

        return view('rezervacije.forma', array_merge(
            ['rezervacija' => $rezervacija, 'termini' => $termini, 'hoteli' => $hoteli],
            $this->getDropdownData()
        ));
    }
    public function update(UpdateRezervacijaRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $brojOdraslih = (int) $request->broj_odraslih;
            $brojDece     = (int) $request->broj_dece;
            $this->service->proveriBrojPutnika($brojOdraslih, $brojDece);

            $rezervacija = Rezervacija::findOrFail($id);
            $putovanje   = Putovanje::findOrFail($request->id_putovanja);
            $ukupna_cena = $this->service->izracunajCenu($putovanje, $request->broj_odraslih, (int) $request->broj_dece);

            $staroBrojPutnika = $rezervacija->broj_odraslih + $rezervacija->broj_dece;
            $noviBrojPutnika  = $brojOdraslih + $brojDece;

            if ((int) $rezervacija->id_termina === (int) $request->id_termina) {
                $razlika = $noviBrojPutnika - $staroBrojPutnika;
                if ($razlika !== 0) {
                    $termin = Termin::findOrFail($request->id_termina);
                    if ($razlika > 0) {
                        $this->service->proveriDostupnaMesta($termin, $razlika);
                    }
                    $termin->decrement('broj_dostupnih_mesta', $razlika);
                }
            } else {
                if ($rezervacija->id_termina) {
                    Termin::find($rezervacija->id_termina)?->increment('broj_dostupnih_mesta', $staroBrojPutnika);
                }
                $noviTermin = Termin::findOrFail($request->id_termina);
                $this->service->proveriDostupnaMesta($noviTermin, $noviBrojPutnika);
                $noviTermin->decrement('broj_dostupnih_mesta', $noviBrojPutnika);
            }

            $data = $request->all();
            $data['ukupna_cena'] = $ukupna_cena;
            
            $rezervacija->update($data);
            
            DB::commit();
            
            return redirect()->route('rezervacije.index')->with('success', 'Rezervacija je uspešno ažurirana!');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('rezervacije.edit', $id)->withInput()->with('fail', $e->getMessage());
        }
    }

    /** Javna stranica za otkazivanje – dostupna putem tokena iz emaila. */
    public function javnoOtkazivanje(string $token)
    {
        $rezervacija = Rezervacija::with(['putovanje', 'termin'])->where('token_otkazivanja', $token)->firstOrFail();

        if ($rezervacija->status === StatusRezervacije::Otkazana) {
            return view('rezervacije.otkazivanje.putnik_otkazivanje', ['rezervacija' => $rezervacija, 'vec_otkazana' => true, 'povratnaCena' => 0]);
        }

        ['danaPre' => $danaPre, 'kaznaProcenat' => $kaznaProcenat, 'kaznaCena' => $kaznaCena, 'povratnaCena' => $povratnaCena]
            = $this->service->izracunajOtkazivanje($rezervacija);

        return view('rezervacije.otkazivanje.putnik_otkazivanje', compact(
            'rezervacija', 'token', 'danaPre', 'kaznaProcenat', 'kaznaCena', 'povratnaCena'
        ));
    }

    /** Primenjuje otkazivanje putem tokena iz emaila. */
    public function javnoPotvrdiOtkazivanje(string $token)
    {
        $rezervacija = Rezervacija::with('putovanje')->where('token_otkazivanja', $token)->firstOrFail();

        if ($rezervacija->status === StatusRezervacije::Otkazana) {
            return redirect()->route('rezervacije.javno.otkazivanje', $token)
                ->with('info', 'Ova rezervacija je već otkazana.');
        }

        ['povratnaCena' => $povratnaCena] = $this->service->izracunajOtkazivanje($rezervacija);

        $this->service->otkaziRezervaciju($rezervacija);

        return redirect()->route('rezervacije.javno.otkazivanje', $token)
            ->with('success', 'Vaša rezervacija je uspešno otkazana.')
            ->with('povratnaCena', $povratnaCena);
    }

    /** Prikazuje stranicu za potvrdu otkazivanja sa izračunatom kaznenom naknadom. */
    public function otkazivanje(string $id)
    {
        $rezervacija  = Rezervacija::with(['putovanje', 'termin'])->findOrFail($id);
        ['danaPre' => $danaPre, 'kaznaProcenat' => $kaznaProcenat, 'kaznaCena' => $kaznaCena, 'povratnaCena' => $povratnaCena]
            = $this->service->izracunajOtkazivanje($rezervacija);

        return view('rezervacije.otkazivanje.admin_otkazivanje', compact(
            'rezervacija', 'danaPre', 'kaznaProcenat', 'kaznaCena', 'povratnaCena'
        ));
    }

    /** Primenjuje otkazivanje – menja status i smanjuje broj rezervacija. */
    public function potvrdiOtkazivanje(string $id)
    {
        $rezervacija = Rezervacija::findOrFail($id);
        $this->service->otkaziRezervaciju($rezervacija);

        return redirect()->route('rezervacije.index')->with('success', 'Rezervacija je uspešno otkazana.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $rezervacija = Rezervacija::findOrFail($id);
            
            // Vrati mesta na termin i broj rezervacija na putovanje, ako već nije otkazana
            if ($rezervacija->status !== StatusRezervacije::Otkazana) {
                $this->service->osloboditKapacitet($rezervacija);
            }
            
            $rezervacija->delete();
            
            return response()->json(['success' => true, 'message' => 'Rezervacija je uspešno obrisana!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
