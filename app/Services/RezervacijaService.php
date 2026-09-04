<?php

namespace App\Services;

use App\Mail\RezervacijaAdminMail;
use App\Mail\RezervacijaPotvrdaMail;
use App\Models\Putovanje;
use App\Models\Rezervacija;
use App\Models\Termin;
use Illuminate\Support\Facades\Mail;

class RezervacijaService
{
    public function __construct(private PravilaService $pravila) {}

    public function izracunajCenu(Putovanje $putovanje, int $brojOdraslih, int $brojDece): float
    {
        $popust = $this->pravila->popustDeceProcenat() / 100;
        return $putovanje->cena * $brojOdraslih + ($putovanje->cena * $popust) * $brojDece;
    }

    /**
     * Proverava poslovna pravila za maksimalan broj odraslih, dece i ukupnog broja putnika.
     *
     * @throws \InvalidArgumentException ako neko od pravila nije zadovoljeno.
     */
    public function proveriBrojPutnika(int $brojOdraslih, int $brojDece): void
    {
        if ($brojOdraslih > $this->pravila->maxOdraslih()) {
            throw new \InvalidArgumentException("Maksimalan broj odraslih putnika je {$this->pravila->maxOdraslih()}.");
        }
        if ($brojDece > $this->pravila->maxDece()) {
            throw new \InvalidArgumentException("Maksimalan broj dece je {$this->pravila->maxDece()}.");
        }
        if (($brojOdraslih + $brojDece) > $this->pravila->maxUkupnoPutnika()) {
            throw new \InvalidArgumentException("Maksimalan ukupan broj putnika je {$this->pravila->maxUkupnoPutnika()}.");
        }
    }

    /**
     * Proverava da li je rezervacija napravljena dovoljno dana pre polaska.
     *
     * @throws \InvalidArgumentException ako je do polaska ostalo manje dana nego što pravilo dozvoljava.
     */
    public function proveriMinDanaPrePolaska(Termin $termin): void
    {
        $danaDo  = (int) now()->diffInDays($termin->datum_od, false);
        $minDana = $this->pravila->minDanaUnapred();
        if ($danaDo < $minDana) {
            throw new \InvalidArgumentException("Rezervacija mora biti napravljena najmanje {$minDana} dana pre polaska.");
        }
    }

    public function posaljiEmailPotvrde(Rezervacija $rezervacija): void
    {
        $rezervacija->load(['putovanje', 'termin']);

        Mail::to($rezervacija->email)->send(new RezervacijaPotvrdaMail($rezervacija));
        Mail::to(config('mail.admin_address'))->send(new RezervacijaAdminMail($rezervacija));
    }

    /** Izračunava broj dana do polaska, procenat i iznos kazne, i iznos koji se vraća gostu. */
    public function izracunajOtkazivanje(Rezervacija $rezervacija): array
    {
        $danaPre       = max(0, (int) now()->diffInDays($rezervacija->termin->datum_od, false));
        $kaznaProcenat = $this->pravila->kaznaOtkazivanja($danaPre);
        $kaznaCena     = round($rezervacija->ukupna_cena * $kaznaProcenat / 100, 2);
        $povratnaCena  = round($rezervacija->ukupna_cena - $kaznaCena, 2);

        return compact('danaPre', 'kaznaProcenat', 'kaznaCena', 'povratnaCena');
    }
}
