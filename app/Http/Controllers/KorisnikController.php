<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreKorisnikRequest;
use App\Models\User;

class KorisnikController extends Controller
{
     public function tabela()
    {
        $korisnici = User::select('users.*');

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
        $korisnik = new User();
        return view('korisnik.forma', compact('korisnik'));
    }

    public function store(StoreKorisnikRequest $request)
    {
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('korisnici.index')->with('success', 'Korisnik je uspešno dodat!');
    }

    public function mojNalog()
    {
        $korisnik = auth()->user();
        $redirectTo = 'pocetna';
        return view('korisnik.forma', compact('korisnik', 'redirectTo'));
    }

    public function show(string $id)
    {
        $korisnik = User::findOrFail($id);
        return view('korisnik.show', compact('korisnik'));
    }

    public function edit(string $id)
    {
        $korisnik = User::findOrFail($id);
        return view('korisnik.forma', compact('korisnik'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $korisnik = User::findOrFail($id);
        $korisnik->name  = $request->name;
        $korisnik->email = $request->email;

        if ($request->filled('password')) {
            $korisnik->password = Hash::make($request->password);
        }

        $korisnik->save();

        $redirectTo = $request->input('_redirect', 'korisnici.index');
        $message = $redirectTo === 'pocetna' ? 'Nalog je uspešno izmenjen!' : 'Korisnik je uspešno izmenjen!';

        return redirect()->route($redirectTo)->with('success', $message);
    }

    public function destroy(string $id)
    {
        try {
            $korisnik = User::findOrFail($id);
            $korisnik->delete();
            return response()->json(['success' => true, 'message' => 'Korisnik je uspešno obrisan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
