<?php

namespace App\Services;

use App\Enums\StatusRezervacije;
use App\Models\Putovanje;
use App\Models\Rezervacija;

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
            ->where('status', StatusRezervacije::Potvrdjena)
            ->sum('ukupna_cena');
    }

    private function aktivnaPutovanja(): int
    {
        return Putovanje::whereHas('termini', fn($q) => $q->where('datum_od', '>=', now()))->count();
    }

    private function ukupnoPutnika(): int
    {
        $rezervacije = Rezervacija::where('status', '!=', StatusRezervacije::Otkazana);
        return (int) $rezervacije->sum('broj_odraslih') + (int) $rezervacije->sum('broj_dece');
    }

    /** Grupiše broj rezervacija po mesecima za poslednjih 6 meseci. */
    private function rezervacijePoMesecima()
    {
        return Rezervacija::where('created_at', '>=', now()->subMonths(6))
            ->orderBy('created_at')
            ->get(['created_at'])
            ->groupBy(fn($rezervacija) => $rezervacija->created_at->format('M Y'))
            ->map(fn($grupa, $mesec) => (object) ['mesec' => $mesec, 'broj' => $grupa->count()])
            ->values();
    }

    private function statusStats(): array
    {
        return [
            'nova'      => Rezervacija::where('status', StatusRezervacije::Nova)->count(),
            'potvrđena' => Rezervacija::where('status', StatusRezervacije::Potvrdjena)->count(),
            'otkazana'  => Rezervacija::where('status', StatusRezervacije::Otkazana)->count(),
        ];
    }

    private function topDestinacije()
    {
        return Putovanje::withCount(['rezervacije as broj_rezervacija' => fn($q) => $q->where('status', '!=', StatusRezervacije::Otkazana)])
            ->withSum(['rezervacije as ukupan_prihod' => fn($q) => $q->where('status', '!=', StatusRezervacije::Otkazana)], 'ukupna_cena')
            ->having('broj_rezervacija', '>', 0)
            ->orderByDesc('broj_rezervacija')
            ->limit(5)
            ->get(['id', 'naziv']);
    }

    private function nedavneRezervacije()
    {
        return Rezervacija::with('putovanje')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }
}

