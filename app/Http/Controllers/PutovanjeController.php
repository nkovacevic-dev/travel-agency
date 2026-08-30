<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePutovanjeRequest;
use App\Models\Drzava;
use App\Models\Hotel;
use App\Models\Putovanje;
use App\Models\TipPrevoza;
use App\Models\TipSobe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PutovanjeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function tabela()
    {
        $query = Putovanje::with('termini')
            ->select('putovanjas.*', 'drzavas.naziv as naziv_drzave', 'tip_prevozas.naziv as naziv_prevoza')
            ->leftJoin('drzavas', 'drzavas.id', 'putovanjas.id_drzave')
            ->leftJoin('tip_prevozas', 'tip_prevozas.id', 'putovanjas.id_tip_prevoza');

        return datatables()->of($query)
            ->addColumn('termini', 'putovanje.dt.kolona_termini')
            ->addColumn('akcija', 'putovanje.dt.kolona_akcije')
            ->rawColumns(['termini', 'akcija'])
            ->make(true);
    }

    public function index()
    {
        return view('putovanje.lista');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $putovanje = new Putovanje();

        $drzave = Drzava::all()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->naziv];
        });
        $hoteli = Hotel::all()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->naziv];
        });
        $tip_sobe = TipSobe::all()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->naziv];
        });
        $tip_prevoza = TipPrevoza::all()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->naziv];
        });
        $termini = [];
        return view('putovanje.forma', compact('putovanje', 'drzave', 'hoteli', 'tip_sobe', 'tip_prevoza', 'termini'));
    }

    /**
     * Store a newly created resource in storage.
     */
    private function saveGalerija(Request $request): array
    {
        $paths = [];
        foreach ($request->file('galerija_slika', []) as $file) {
            $paths[] = $file->store('putovanja', 'public');
        }
        return $paths;
    }

    public function store(StorePutovanjeRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->except(['termini', 'galerija_slika']);
            $data['galerija_slika'] = $this->saveGalerija($request);
            $putovanje = Putovanje::create($data);
            foreach ($request->input('termini', []) as $termin) {
                $putovanje->termini()->create([
                    'datum_od' => Carbon::createFromFormat('d.m.Y.', $termin['datum_od']),
                    'datum_do' => Carbon::createFromFormat('d.m.Y.', $termin['datum_do']),
                    'broj_dostupnih_mesta' => $termin['broj_dostupnih_mesta'],
                ]);
            }
            DB::commit();
            return redirect()->route('putovanja.index')->with('success', __('Putovanje je uspešno uneto!'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('putovanja.create')->withInput()->with('fail', $e->getMessage());
        }
    }

    /**
     * Display the specified resource (javni prikaz).
     */
    public function show(string $id)
    {
        $putovanje = Putovanje::with(['drzava', 'hotel', 'tipSobe', 'tipPrevoza'])->findOrFail($id);

        $tip_sobe = TipSobe::all()->map(fn($item) => ['id' => $item->id, 'text' => $item->naziv]);
        $drzave   = Drzava::all()->map(fn($item) => ['id' => $item->id, 'text' => $item->naziv]);
        $hoteli   = Hotel::all()->map(fn($item) => ['id' => $item->id, 'text' => $item->naziv]);
        $tip_prevoza = TipPrevoza::all()->map(fn($item) => ['id' => $item->id, 'text' => $item->naziv]);

        $termini = $putovanje->termini->map(fn($t) => [
            'datum_od'             => $t->datum_od->format('d.m.Y.'),
            'datum_do'             => $t->datum_do->format('d.m.Y.'),
            'broj_dostupnih_mesta' => $t->broj_dostupnih_mesta,
        ])->toArray();

        $rezervacije = $putovanje->rezervacije()->with('tipSobe')->get();

        return view('putovanje.prikaz', compact('putovanje', 'tip_sobe', 'drzave', 'hoteli', 'tip_prevoza', 'termini', 'rezervacije'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $putovanje = Putovanje::findOrFail($id);
        
        $drzave = Drzava::all()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->naziv];
        });
        $hoteli = Hotel::all()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->naziv];
        });
        $tip_sobe = TipSobe::all()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->naziv];
        });
        $tip_prevoza = TipPrevoza::all()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->naziv];
        });
        
        $termini = $putovanje->termini->map(fn($t) => [
            'datum_od' => $t->datum_od->format('d.m.Y.'),
            'datum_do' => $t->datum_do->format('d.m.Y.'),
            'broj_dostupnih_mesta' => $t->broj_dostupnih_mesta,
        ])->toArray();

        return view('putovanje.forma', compact('putovanje', 'drzave', 'hoteli', 'tip_sobe', 'tip_prevoza', 'termini'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePutovanjeRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $putovanje = Putovanje::findOrFail($id);
            $data = $request->except(['termini', 'galerija_slika']);
            if ($request->hasFile('galerija_slika')) {
                foreach ($putovanje->galerija_slika ?? [] as $oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }
                $data['galerija_slika'] = $this->saveGalerija($request);
            }
            $putovanje->update($data);
            $putovanje->termini()->delete();
            foreach ($request->input('termini', []) as $termin) {
                $putovanje->termini()->create([
                    'datum_od' => Carbon::createFromFormat('d.m.Y.', $termin['datum_od']),
                    'datum_do' => Carbon::createFromFormat('d.m.Y.', $termin['datum_do']),
                    'broj_dostupnih_mesta' => $termin['broj_dostupnih_mesta'],
                ]);
            }
            DB::commit();
            return redirect()->route('putovanja.index')->with('success', __('Putovanje je uspešno ažurirano!'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('putovanja.edit', $id)->withInput()->with('fail', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $putovanje = Putovanje::findOrFail($id);
            
            // Proveri da li postoje rezervacije
            if ($putovanje->rezervacije()->count() > 0) {
                return response()->json(['success' => false, 'message' => 'Ne možete obrisati putovanje koje ima rezervacije!'], 400);
            }
            
            foreach ($putovanje->galerija_slika ?? [] as $path) {
                Storage::disk('public')->delete($path);
            }
            $putovanje->delete();
            return response()->json(['success' => true, 'message' => 'Putovanje je uspešno obrisano!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
