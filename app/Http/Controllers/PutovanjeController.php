<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePutovanjeRequest;
use App\Models\Drzava;
use App\Models\Hotel;
use App\Models\Putovanje;
use App\Models\TipPrevoza;
use App\Models\TipSobe;
use Illuminate\Http\Request;

class PutovanjeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function tabela()
    {
        $query = \DB::table('putovanjas')
            ->select('putovanjas.*', 'drzavas.naziv as naziv_drzave', 'tip_prevozas.naziv as naziv_prevoza')
            ->leftJoin('drzavas', 'drzavas.id', 'putovanjas.id_drzave')
            ->leftJoin('tip_prevozas', 'tip_prevozas.id', 'putovanjas.id_tip_prevoza');

        return datatables()->of($query)
            ->addColumn('akcija', 'putovanje.dt.kolona_akcije')
            ->rawColumns(['akcija'])
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
        return view('putovanje.forma', compact('putovanje', 'drzave', 'hoteli', 'tip_sobe', 'tip_prevoza'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePutovanjeRequest $request)
    {
        try {
            DB::beginTransaction();
            $putovanje = Putovanje::create($request->all());
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
        
        $tip_sobe = TipSobe::all()->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->naziv];
        });
        
        return view('putovanje.prikaz', compact('putovanje', 'tip_sobe'));
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
        
        return view('putovanje.forma', compact('putovanje', 'drzave', 'hoteli', 'tip_sobe', 'tip_prevoza'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePutovanjeRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $putovanje = Putovanje::findOrFail($id);
            $putovanje->update($request->all());
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
            
            $putovanje->delete();
            return response()->json(['success' => true, 'message' => 'Putovanje je uspešno obrisano!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
