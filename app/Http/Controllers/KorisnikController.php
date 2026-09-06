<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKorisnikRequest;
use App\Http\Requests\UpdateKorisnikRequest;
use App\Models\Korisnik;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KorisnikController extends Controller
{
     public function tabela()
    {
        $korisnici = Korisnik::select('korisnik.*');

        return datatables()->of($korisnici)
        ->addColumn('akcija', 'korisnik.dt.kolona_akcije')
        ->rawColumns(['akcija'])
        ->make(true);
    }

    public function index()
    {
        return view('korisnik.lista');
    }

    public function create()
    {
        $korisnik = new Korisnik();
        return view('korisnik.forma', compact('korisnik'));
    }

    public function store(StoreKorisnikRequest $request)
    {
        try {
            DB::beginTransaction();
            Korisnik::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);
            DB::commit();
            return redirect()->route('korisnici.index')->with('success', 'Korisnik je uspešno dodat!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('korisnici.create')->withInput()->with('fail', $e->getMessage());
        }
    }

    public function mojNalog()
    {
        $korisnik = Auth::user();
        $redirectTo = 'pocetna';
        return view('korisnik.forma', compact('korisnik', 'redirectTo'));
    }

    public function show(string $id)
    {
        $korisnik = Korisnik::findOrFail($id);
        return view('korisnik.prikaz', compact('korisnik'));
    }

    public function edit(string $id)
    {
        $korisnik = Korisnik::findOrFail($id);
        return view('korisnik.forma', compact('korisnik'));
    }

    public function update(UpdateKorisnikRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $korisnik = Korisnik::findOrFail($id);
            $korisnik->name  = $request->name;
            $korisnik->email = $request->email;

            if ($request->filled('password')) {
                $korisnik->password = Hash::make($request->password);
            }

            $korisnik->save();
            DB::commit();

            $redirectTo = $request->input('_redirect', 'korisnici.index');
            $message    = $redirectTo === 'pocetna' ? 'Nalog je uspešno izmenjen!' : 'Korisnik je uspešno izmenjen!';

            return redirect()->route($redirectTo)->with('success', $message);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('korisnici.edit', $id)->withInput()->with('fail', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $korisnik = Korisnik::findOrFail($id);

            if (Auth::id() === $korisnik->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nije moguće obrisati trenutno prijavljeni nalog.',
                ], 422);
            }

            $korisnik->delete();
            return response()->json(['success' => true, 'message' => 'Korisnik je uspešno obrisan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
