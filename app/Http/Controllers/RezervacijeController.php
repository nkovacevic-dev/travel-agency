<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRezervacijaRequest;
use App\Http\Requests\UpdateRezervacijaRequest;
use App\Models\Rezervacije;
use App\Models\Putovanje;
use App\Models\Hotel;
use App\Models\TipSobe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RezervacijeController extends Controller
{
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

    /**
     * Show the form for creating a new resource (admin).
     */
    public function create()
    {
        $rezervacija = new Rezervacije();
        
        $putovanja = Putovanje::all()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->naziv];
        });
        
        $hoteli = Hotel::all()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->naziv];
        });
        
        $tip_sobe = TipSobe::all()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->naziv];
        });

        $termini = [];
        $hoteli = [];
        return view('rezervacije.forma', compact('rezervacija', 'putovanja', 'hoteli', 'tip_sobe', 'termini'));
    }
    public function store(StoreRezervacijaRequest $request)
    {
        try {
            DB::beginTransaction();
            
            // Izračunaj ukupnu cenu
            $putovanje = Putovanje::findOrFail($request->id_putovanja);
            $ukupna_cena = $putovanje->cena * $request->broj_odraslih;
            if ($request->broj_dece) {
                $ukupna_cena += ($putovanje->cena * 0.5) * $request->broj_dece; // Deca 50% popusta
            }
            
            $data = $request->all();
            $data['ukupna_cena'] = $ukupna_cena;
            $data['status'] = 'nova';
            
            $rezervacija = Rezervacije::create($data);
            
            // Ažuriraj broj rezervacija za putovanje
            $putovanje->increment('broj_rezervacija');
            
            DB::commit();

            // Pošalji email (opciono)
            try {
                $this->posaljiEmailPotvrde($rezervacija);
            } catch (\Exception $e) {
                // Log error ali ne prekidaj proces
                \Log::error('Greška pri slanju email-a: ' . $e->getMessage());
            }

            // Ako je admin, vrati na listu, ako je javno, vrati poruku uspešnosti
            if (auth()->check()) {
                return redirect()->route('rezervacije.index')->with('success', 'Rezervacija je uspešno kreirana!');
            } else {
                return redirect()->route('pocetna')->with('success', 'Vaša rezervacija je uspešno primljena! Potvda je poslata na Vaš email.');
            }
            
        } catch (\Exception $e) {
            DB::rollback();
            
            if (auth()->check()) {
                return redirect()->route('rezervacije.create')->withInput()->with('fail', $e->getMessage());
            } else {
                return back()->withInput()->with('fail', 'Došlo je do greške pri kreiranju rezervacije. Molimo pokušajte ponovo.');
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rezervacija = Rezervacije::findOrFail($id);
        
        $putovanja = Putovanje::all()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->naziv];
        });
        
        $hoteli = Hotel::all()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->naziv];
        });
        
        $tip_sobe = TipSobe::all()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->naziv];
        });

        // Pre-populate termini i hoteli za odabrano putovanje
        $termini = [];
        $hoteli = [];
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

        return view('rezervacije.forma', compact('rezervacija', 'putovanja', 'hoteli', 'tip_sobe', 'termini'));
    }
    public function update(UpdateRezervacijaRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            
            $rezervacija = Rezervacije::findOrFail($id);
            
            // Izračunaj ukupnu cenu
            $putovanje = Putovanje::findOrFail($request->id_putovanja);
            $ukupna_cena = $putovanje->cena * $request->broj_odraslih;
            if ($request->broj_dece) {
                $ukupna_cena += ($putovanje->cena * 0.5) * $request->broj_dece;
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

    /**
     * Pošalji email potvrdu.
     */
    private function posaljiEmailPotvrde($rezervacija)
    {
        // TODO: Implementirati slanje email-a
        // Mail::to($rezervacija->email)->send(new RezervacijaPotvrdaMail($rezervacija));
    }
}

