<?php

namespace App\Services;

use App\Models\Putovanje;
use App\Models\Rezervacija;
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
        return Rezervacija::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    private function prihodMesec(): float
    {
        return Rezervacija::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'potvrđena')
            ->sum('ukupna_cena');
    }

    private function aktivnaPutovanja(): int
    {
        return Putovanje::whereHas('termini', fn($q) => $q->where('datum_od', '>=', now()))->count();
    }

    private function ukupnoPutnika(): int
    {
        return Rezervacija::where('status', '!=', 'otkazana')
            ->sum(DB::raw('broj_odraslih + broj_dece'));
    }

    private function rezervacijePoMesecima()
    {
        return Rezervacija::selectRaw('DATE_FORMAT(created_at, "%b %Y") as mesec, COUNT(*) as broj')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('mesec')
            ->orderBy(DB::raw('MIN(created_at)'))
            ->get();
    }

    private function statusStats(): array
    {
        return [
            'nova'      => Rezervacija::where('status', 'nova')->count(),
            'potvrđena' => Rezervacija::where('status', 'potvrđena')->count(),
            'otkazana'  => Rezervacija::where('status', 'otkazana')->count(),
        ];
    }

    private function topDestinacije()
    {
        return Putovanje::select(
                'putovanje.naziv',
                DB::raw('COUNT(rezervacija.id) as broj_rezervacija'),
                DB::raw('SUM(rezervacija.ukupna_cena) as ukupan_prihod')
            )
            ->join('rezervacija', 'putovanje.id', '=', 'rezervacija.id_putovanja')
            ->where('rezervacija.status', '!=', 'otkazana')
            ->groupBy('putovanje.id', 'putovanje.naziv')
            ->orderBy('broj_rezervacija', 'desc')
            ->limit(5)
            ->get();
    }

    private function nedavneRezervacije()
    {
        return Rezervacija::with('putovanje')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }
}
