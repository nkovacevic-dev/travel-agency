<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePutovanjeRequest;
use App\Models\Drzava;
use App\Models\Hotel;
use App\Models\Putovanje;
use App\Models\TipPrevoza;
use App\Models\TipSobe;
use App\Services\PutovanjeService;
use App\Support\SelectOptions;
use App\ViewModels\PutovanjeViewModel;
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
        return [
            'drzave'      => SelectOptions::odNaziva(Drzava::all()),
            'hoteli'      => SelectOptions::odNaziva(Hotel::all()),
            'tip_sobe'    => SelectOptions::odNaziva(TipSobe::all()),
            'tip_prevoza' => SelectOptions::odNaziva(TipPrevoza::all()),
        ];
    }

    public function tabela()
    {
        $query = Putovanje::with('termini')
            ->select('putovanje.*', 'drzava.naziv as naziv_drzave', 'tip_prevoza.naziv as naziv_prevoza')
            ->leftJoin('drzava', 'drzava.id', 'putovanje.id_drzave')
            ->leftJoin('tip_prevoza', 'tip_prevoza.id', 'putovanje.id_tip_prevoza');

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
        $putovanje = Putovanje::with(['drzava', 'hotel', 'tipPrevoza', 'slike'])->findOrFail($id);

        if (!Auth::check()) {
            return view('pocetna.prikaz', [
                'viewModel' => new PutovanjeViewModel($putovanje),
            ]);
        }

        $rezervacije = $putovanje->rezervacije()->with('tipSobe')->get();
        $termini = $putovanje->termini->map(fn($t) => [
            'id'                   => $t->id,
            'datum_od'             => $t->datum_od->format('d.m.Y.'),
            'datum_do'             => $t->datum_do->format('d.m.Y.'),
            'broj_dostupnih_mesta' => $t->broj_dostupnih_mesta,
        ])->toArray();

        return view('putovanje.prikaz',
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
