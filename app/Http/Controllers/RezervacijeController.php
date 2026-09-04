<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRezervacijaRequest;
use App\Http\Requests\UpdateRezervacijaRequest;
use App\Models\Drzava;
use App\Models\Hotel;
use App\Models\Putovanje;
use App\Models\Rezervacija;
use App\Models\Termin;
use App\Models\TipSobe;
use App\Services\PravilaService;
use App\Services\RezervacijaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RezervacijeController extends Controller
{
    public function __construct(
        private RezervacijaService $service,
        private PravilaService $pravila
    ) {}

    private function getDropdownData(): array
    {
        $toSelect = fn($item) => ['id' => $item->id, 'text' => $item->naziv];
        return [
            'putovanja' => Putovanje::all()->map($toSelect)->toArray(),
            'tip_sobe'  => TipSobe::all()->map($toSelect)->toArray(),
            'drzave'    => Drzava::orderBy('naziv')->get()->map($toSelect)->toArray(),
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
                'terminis.datum_od',
                'terminis.datum_do'
            )
            ->leftJoin('putovanje', 'putovanje.id', '=', 'rezervacija.id_putovanja')
            ->leftJoin('terminis', 'terminis.id', '=', 'rezervacija.id_termina')
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

            // Poslovna pravila iz JSON konfiguracije
            $brojOdraslih = (int) $request->broj_odraslih;
            $brojDece     = (int) $request->broj_dece;

            if ($brojOdraslih > $this->pravila->maxOdraslih()) {
                throw new \InvalidArgumentException("Maksimalan broj odraslih putnika je {$this->pravila->maxOdraslih()}.");
            }
            if ($brojDece > $this->pravila->maxDece()) {
                throw new \InvalidArgumentException("Maksimalan broj dece je {$this->pravila->maxDece()}.");
            }
            if (($brojOdraslih + $brojDece) > $this->pravila->maxUkupnoPutnika()) {
                throw new \InvalidArgumentException("Maksimalan ukupan broj putnika je {$this->pravila->maxUkupnoPutnika()}.");
            }

            $termin  = Termin::findOrFail($request->id_termina);
            $danaDo  = (int) now()->diffInDays($termin->datum_od, false);
            $minDana = $this->pravila->minDanaUnapred();
            if ($danaDo < $minDana) {
                throw new \InvalidArgumentException("Rezervacija mora biti napravljena najmanje {$minDana} dana pre polaska.");
            }

            // Izračunaj ukupnu cenu
            $putovanje = Putovanje::findOrFail($request->id_putovanja);
            $ukupna_cena = $this->service->izracunajCenu($putovanje, $request->broj_odraslih, (int) $request->broj_dece);
            
            $data = $request->all();
            $data['ukupna_cena'] = $ukupna_cena;
            $data['status'] = 'nova';
            
            $rezervacija = Rezervacija::create($data);
            
            // Ažuriraj broj rezervacija za putovanje
            $putovanje->increment('broj_rezervacija');
            
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
                $hoteli = Hotel::where('id_drzave', $putovanje->id_drzave)->get()->map(fn($h) => [
                    'id' => $h->id, 'text' => $h->naziv,
                ])->toArray();
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

            // Poslovna pravila iz JSON konfiguracije
            $brojOdraslih = (int) $request->broj_odraslih;
            $brojDece     = (int) $request->broj_dece;

            if ($brojOdraslih > $this->pravila->maxOdraslih()) {
                throw new \InvalidArgumentException("Maksimalan broj odraslih putnika je {$this->pravila->maxOdraslih()}.");
            }
            if ($brojDece > $this->pravila->maxDece()) {
                throw new \InvalidArgumentException("Maksimalan broj dece je {$this->pravila->maxDece()}.");
            }
            if (($brojOdraslih + $brojDece) > $this->pravila->maxUkupnoPutnika()) {
                throw new \InvalidArgumentException("Maksimalan ukupan broj putnika je {$this->pravila->maxUkupnoPutnika()}.");
            }

            $rezervacija = Rezervacija::findOrFail($id);
            $putovanje   = Putovanje::findOrFail($request->id_putovanja);
            $ukupna_cena = $this->service->izracunajCenu($putovanje, $request->broj_odraslih, (int) $request->broj_dece);
            
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
        $rezervacija = Rezervacija::with(['putovanje', 'termin'])->where('cancel_token', $token)->firstOrFail();

        if ($rezervacija->status === 'otkazana') {
            return view('rezervacije.otkazivanje.putnik_otkazivanje', ['rezervacija' => $rezervacija, 'vec_otkazana' => true, 'povratnaCena' => 0]);
        }

        $danaPre       = max(0, (int) now()->diffInDays($rezervacija->termin->datum_od, false));
        $kaznaProcenat = $this->pravila->kaznaOtkazivanja($danaPre);
        $kaznaCena     = round($rezervacija->ukupna_cena * $kaznaProcenat / 100, 2);
        $povratnaCena  = round($rezervacija->ukupna_cena - $kaznaCena, 2);

        return view('rezervacije.otkazivanje.putnik_otkazivanje', compact(
            'rezervacija', 'token', 'danaPre', 'kaznaProcenat', 'kaznaCena', 'povratnaCena'
        ));
    }

    /** Primenjuje otkazivanje putem tokena iz emaila. */
    public function javnoPotvrdiOtkazivanje(string $token)
    {
        $rezervacija = Rezervacija::with('putovanje')->where('cancel_token', $token)->firstOrFail();

        if ($rezervacija->status === 'otkazana') {
            return redirect()->route('rezervacije.javno.otkazivanje', $token)
                ->with('info', 'Ova rezervacija je već otkazana.');
        }

        $danaPre      = max(0, (int) now()->diffInDays($rezervacija->termin->datum_od, false));
        $kaznaProcenat = $this->pravila->kaznaOtkazivanja($danaPre);
        $kaznaCena    = round($rezervacija->ukupna_cena * $kaznaProcenat / 100, 2);
        $povratnaCena = round($rezervacija->ukupna_cena - $kaznaCena, 2);

        $rezervacija->update(['status' => 'otkazana']);

        if ($rezervacija->putovanje) {
            $rezervacija->putovanje->decrement('broj_rezervacija');
        }

        return redirect()->route('rezervacije.javno.otkazivanje', $token)
            ->with('success', 'Vaša rezervacija je uspešno otkazana.')
            ->with('povratnaCena', $povratnaCena);
    }

    /** Prikazuje stranicu za potvrdu otkazivanja sa izračunatom kaznenom naknadom. */
    public function otkazivanje(string $id)
    {
        $rezervacija  = Rezervacija::with(['putovanje', 'termin'])->findOrFail($id);
        $danaPre      = max(0, (int) now()->diffInDays($rezervacija->termin->datum_od, false));
        $kaznaProcenat = $this->pravila->kaznaOtkazivanja($danaPre);
        $kaznaCena    = round($rezervacija->ukupna_cena * $kaznaProcenat / 100, 2);
        $povratnaCena = round($rezervacija->ukupna_cena - $kaznaCena, 2);

        return view('rezervacije.otkazivanje.admin_otkazivanje', compact(
            'rezervacija', 'danaPre', 'kaznaProcenat', 'kaznaCena', 'povratnaCena'
        ));
    }

    /** Primenjuje otkazivanje – menja status i smanjuje broj rezervacija. */
    public function potvrdiOtkazivanje(string $id)
    {
        $rezervacija = Rezervacija::findOrFail($id);
        $rezervacija->update(['status' => 'otkazana']);

        if ($rezervacija->putovanje) {
            $rezervacija->putovanje->decrement('broj_rezervacija');
        }

        return redirect()->route('rezervacije.index')->with('success', 'Rezervacija je uspešno otkazana.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $rezervacija = Rezervacija::findOrFail($id);
            
            // Dekrementuj broj rezervacija za putovanje
            if ($rezervacija->putovanje) {
                $rezervacija->putovanje->decrement('broj_rezervacija');
            }
            
            $rezervacija->delete();
            
            return response()->json(['success' => true, 'message' => 'Rezervacija je uspešno obrisana!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
