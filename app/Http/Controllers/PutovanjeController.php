<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePutovanjeRequest;
use App\Models\Drzava;
use App\Models\Hotel;
use App\Models\Putovanje;
use App\Models\TipPrevoza;
use App\Models\TipSobe;
use App\Services\PutovanjeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PutovanjeController extends Controller
{
    public function __construct(private PutovanjeService $service) {}
    /**
     * Display a listing of the resource.
     */

    private function getDropdownData(): array
    {
        $toSelect = fn($item) => ['id' => $item->id, 'text' => $item->naziv];
        return [
            'drzave'      => Drzava::all()->map($toSelect)->toArray(),
            'hoteli'      => Hotel::all()->map($toSelect)->toArray(),
            'tip_sobe'    => TipSobe::all()->map($toSelect)->toArray(),
            'tip_prevoza' => TipPrevoza::all()->map($toSelect)->toArray(),
        ];
    }

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
        $termini   = [];
        return view('putovanje.forma', array_merge(['putovanje' => $putovanje, 'termini' => $termini], $this->getDropdownData()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePutovanjeRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->except(['termini', 'galerija_slika']);
            $putovanje = Putovanje::create($data);
            $this->service->sacuvajSlike($putovanje, $request->file('galerija_slika', []));
            $this->service->sacuvajTermine($putovanje, $request->input('termini', []));
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
        $putovanje = Putovanje::with(['drzava', 'hotel', 'tipSobe', 'tipPrevoza', 'slike'])->findOrFail($id);

        $tip_sobe = TipSobe::all()->map(fn($item) => ['id' => $item->id, 'text' => $item->naziv]);
        $drzave   = Drzava::all()->map(fn($item) => ['id' => $item->id, 'text' => $item->naziv]);
        $hoteli   = Hotel::all()->map(fn($item) => ['id' => $item->id, 'text' => $item->naziv]);
        $tip_prevoza = TipPrevoza::all()->map(fn($item) => ['id' => $item->id, 'text' => $item->naziv]);

        $termini = $putovanje->termini->map(fn($t) => [
            'id'                   => $t->id,
            'datum_od'             => $t->datum_od->format('d.m.Y.'),
            'datum_do'             => $t->datum_do->format('d.m.Y.'),
            'broj_dostupnih_mesta' => $t->broj_dostupnih_mesta,
        ])->toArray();

        $rezervacije = $putovanje->rezervacije()->with('tipSobe')->get();

        return view(Auth::check() ? 'putovanje.prikaz' : 'pocetna.prikaz',
            array_merge(['putovanje' => $putovanje, 'termini' => $termini, 'rezervacije' => $rezervacije], $this->getDropdownData())
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $putovanje = Putovanje::findOrFail($id);
        $termini   = $putovanje->termini->map(fn($t) => [
            'datum_od'             => $t->datum_od->format('d.m.Y.'),
            'datum_do'             => $t->datum_do->format('d.m.Y.'),
            'broj_dostupnih_mesta' => $t->broj_dostupnih_mesta,
        ])->toArray();
        return view('putovanje.forma', array_merge(['putovanje' => $putovanje, 'termini' => $termini], $this->getDropdownData()));
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
                $this->service->obrisiSlike($putovanje);
                $this->service->sacuvajSlike($putovanje, $request->file('galerija_slika'));
            }
            $putovanje->update($data);
            $putovanje->termini()->delete();
            $this->service->sacuvajTermine($putovanje, $request->input('termini', []));
            DB::commit();
            return redirect()->route('putovanja.index')->with('success', __('Putovanje je uspešno ažurirano!'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('putovanja.edit', $id)->withInput()->with('fail', $e->getMessage());
        }
    }

    public function putnici_pdf(string $id)
    {
        $putovanje   = Putovanje::with(['drzava', 'tipPrevoza', 'termini'])->findOrFail($id);
        $rezervacije = $putovanje->rezervacije()->with('tipSobe', 'termin')->get();
        return $this->service->generisiPdfPutnici($putovanje, $rezervacije)
                             ->download('putnici-' . Str::slug($putovanje->naziv) . '.pdf');
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
            
            foreach ($putovanje->slike as $slika) {
                Storage::disk('public')->delete($slika->slika);
            }
            $putovanje->delete();
            return response()->json(['success' => true, 'message' => 'Putovanje je uspešno obrisano!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
