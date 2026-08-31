<?php

namespace App\Services;

use App\Models\Putovanje;
use App\Models\Rezervacije;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getStatistike(): array
    {
        return [
            'rezervacije_mesec'      => $this->rezervacijeMesec(),
            'prihod_mesec'           => $this->prihodMesec(),
            'aktivna_putovanja'      => $this->aktivnaPutovanja(),
            'ukupno_putnika'         => $this->ukupnoPutnika(),
            'rezervacije_po_mesecima'=> $this->rezervacijePoMesecima(),
            'status_stats'           => $this->statusStats(),
            'top_destinacije'        => $this->topDestinacije(),
            'nedavne_rezervacije'    => $this->nedavneRezervacije(),
        ];
    }

    private function rezervacijeMesec(): int
    {
        return Rezervacije::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    private function prihodMesec(): float
    {
        return Rezervacije::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', '!=', 'otkazana')
            ->sum('ukupna_cena');
    }

    private function aktivnaPutovanja(): int
    {
        return Putovanje::whereHas('termini', fn($q) => $q->where('datum_od', '>=', now()))->count();
    }

    private function ukupnoPutnika(): int
    {
        return Rezervacije::where('status', '!=', 'otkazana')
            ->sum(DB::raw('broj_odraslih + broj_dece'));
    }

    private function rezervacijePoMesecima()
    {
        return Rezervacije::selectRaw('DATE_FORMAT(created_at, "%b %Y") as mesec, COUNT(*) as broj')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('mesec')
            ->orderBy(DB::raw('MIN(created_at)'))
            ->get();
    }

    private function statusStats(): array
    {
        return [
            'nova'      => Rezervacije::where('status', 'nova')->count(),
            'potvrđena' => Rezervacije::where('status', 'potvrđena')->count(),
            'otkazana'  => Rezervacije::where('status', 'otkazana')->count(),
        ];
    }

    private function topDestinacije()
    {
        return Putovanje::select(
                'putovanjas.naziv',
                DB::raw('COUNT(rezervacijes.id) as broj_rezervacija'),
                DB::raw('SUM(rezervacijes.ukupna_cena) as ukupan_prihod')
            )
            ->join('rezervacijes', 'putovanjas.id', '=', 'rezervacijes.id_putovanja')
            ->where('rezervacijes.status', '!=', 'otkazana')
            ->groupBy('putovanjas.id', 'putovanjas.naziv')
            ->orderBy('broj_rezervacija', 'desc')
            ->limit(5)
            ->get();
    }

    private function nedavneRezervacije()
    {
        return Rezervacije::with('putovanje')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }
}
