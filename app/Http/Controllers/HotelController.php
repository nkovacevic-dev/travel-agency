<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHotelRequest;
use App\Models\Drzava;
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    private function getDropdownData(): array
    {
        return [
            'drzave' => Drzava::all()->map(fn($i) => ['id' => $i->id, 'text' => $i->naziv])->toArray(),
        ];
    }

    public function poDrzavi(string $id)
    {
        return Hotel::where('id_drzave', $id)->get()->map(fn($h) => ['id' => $h->id, 'text' => $h->naziv]);
    }

    public function tabela()
    {
        $hoteli = Hotel::select('hotel.*', 'drzava.naziv as naziv_drzave')
        ->leftJoin('drzava', 'drzava.id', 'hotel.id_drzave');

        return datatables()->of($hoteli)
        ->addColumn('akcija', 'hotel.dt.kolona_akcije')
        ->rawColumns(['akcija'])
        ->make(true);
    }

    public function index()
    {
        return view('hotel.lista');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hotel = new Hotel();
        return view('hotel.forma', array_merge(['hotel' => $hotel], $this->getDropdownData()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request)
    {
        try {
            DB::beginTransaction();
            $hotel = Hotel::create($request->all());
            DB::commit();
            return redirect()->route('hoteli.index')->with('success', __('Hotel je uspešno unet!'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('hoteli.create')->withInput()->with('fail', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('hotel.forma', array_merge(['hotel' => $hotel], $this->getDropdownData()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreHotelRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $hotel = Hotel::findOrFail($id);
            $hotel->update($request->all());
            DB::commit();
            return redirect()->route('hoteli.index')->with('success', __('Hotel je uspešno ažuriran!'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('hoteli.edit', $id)->withInput()->with('fail', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $hotel = Hotel::findOrFail($id);
            $hotel->delete();
            return response()->json(['success' => true, 'message' => 'Hotel je uspešno obrisan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
