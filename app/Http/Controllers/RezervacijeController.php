<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRezervacijaRequest;
use App\Http\Requests\UpdateRezervacijaRequest;
use App\Models\Drzava;
use App\Models\Hotel;
use App\Models\Putovanje;
use App\Models\Rezervacije;
use App\Models\TipSobe;
use App\Services\RezervacijeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RezervacijeController extends Controller
{
    public function __construct(private RezervacijeService $service) {}

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
        $query = Rezervacije::select(
                'rezervacijes.*',
                'putovanjas.naziv as naziv_putovanja',
                'terminis.datum_od',
                'terminis.datum_do'
            )
            ->leftJoin('putovanjas', 'putovanjas.id', '=', 'rezervacijes.id_putovanja')
            ->leftJoin('terminis', 'terminis.id', '=', 'rezervacijes.id_termina')
            ->orderBy('rezervacijes.created_at', 'desc');

        return datatables()->of($query)
            ->addColumn('akcija', 'rezervacije.dt.kolona_akcije')
            ->addColumn('termin', 'rezervacije.dt.kolona_termin')
            ->rawColumns(['akcija', 'termin'])
            ->make(true);
    }

    public function create()
    {
        $rezervacija = new Rezervacije();
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
            
            // Izračunaj ukupnu cenu
            $putovanje = Putovanje::findOrFail($request->id_putovanja);
            $ukupna_cena = $this->service->izracunajCenu($putovanje, $request->broj_odraslih, (int) $request->broj_dece);
            
            $data = $request->all();
            $data['ukupna_cena'] = $ukupna_cena;
            $data['status'] = 'nova';
            
            $rezervacija = Rezervacije::create($data);
            
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
        $rezervacija = Rezervacije::with(['putovanje', 'hotel', 'tipSobe'])->findOrFail($id);
        return view('rezervacije.prikaz', compact('rezervacija'));
    }

    public function edit(string $id)
    {
        $rezervacija = Rezervacije::findOrFail($id);

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
            
            $rezervacija = Rezervacije::findOrFail($id);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $rezervacija = Rezervacije::findOrFail($id);
            
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
