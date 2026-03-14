<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Putovanje;
use App\Models\Rezervacije;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Ako je korisnik ulogovan, prikaži admin dashboard
        if (Auth::check()) {
            return $this->adminDashboard();
        }
        
        // Javna početna strana
        $putovanja = Putovanje::all();
        return view('pocetna', compact('putovanja'));
    }

    /**
     * Admin dashboard sa statistikama
     */
    private function adminDashboard()
    {
        // Rezervacije ovog meseca
        $rezervacije_mesec = Rezervacije::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Prihod ovog meseca
        $prihod_mesec = Rezervacije::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', '!=', 'otkazana')
            ->sum('ukupna_cena');

        // Aktivna putovanja (u budućnosti)
        $aktivna_putovanja = Putovanje::where('datum_od', '>=', now())->count();

        // Ukupno putnika (broj odraslih + dece)
        $ukupno_putnika = Rezervacije::where('status', '!=', 'otkazana')
            ->sum(DB::raw('broj_odraslih + broj_dece'));

        // Rezervacije po mesecima (poslednih 6 meseci)
        $rezervacije_po_mesecima = Rezervacije::selectRaw('DATE_FORMAT(created_at, "%b %Y") as mesec, COUNT(*) as broj')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('mesec')
            ->orderBy(DB::raw('MIN(created_at)'))
            ->get();

        // Statistika po statusu
        $status_stats = [
            'nova' => Rezervacije::where('status', 'nova')->count(),
            'potvrđena' => Rezervacije::where('status', 'potvrđena')->count(),
            'otkazana' => Rezervacije::where('status', 'otkazana')->count(),
        ];

        // Top 5 destinacija
        $top_destinacije = Putovanje::select('putovanjas.naziv', 
                DB::raw('COUNT(rezervacijes.id) as broj_rezervacija'),
                DB::raw('SUM(rezervacijes.ukupna_cena) as ukupan_prihod'))
            ->join('rezervacijes', 'putovanjas.id', '=', 'rezervacijes.id_putovanja')
            ->where('rezervacijes.status', '!=', 'otkazana')
            ->groupBy('putovanjas.id', 'putovanjas.naziv')
            ->orderBy('broj_rezervacija', 'desc')
            ->limit(5)
            ->get();

        // Nedavne rezervacije
        $nedavne_rezervacije = Rezervacije::with('putovanje')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'rezervacije_mesec',
            'prihod_mesec',
            'aktivna_putovanja',
            'ukupno_putnika',
            'rezervacije_po_mesecima',
            'status_stats',
            'top_destinacije',
            'nedavne_rezervacije'
        ));
    }
}
