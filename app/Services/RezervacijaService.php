<?php

namespace App\Services;

use App\Mail\RezervacijaAdminMail;
use App\Mail\RezervacijaPotvrdaMail;
use App\Models\Putovanje;
use App\Models\Rezervacija;
use Illuminate\Support\Facades\Mail;

class RezervacijaService
{
    public function __construct(private PravilaService $pravila) {}

    public function izracunajCenu(Putovanje $putovanje, int $brojOdraslih, int $brojDece): float
    {
        $popust = $this->pravila->popustDeceProcenat() / 100;
        return $putovanje->cena * $brojOdraslih + ($putovanje->cena * $popust) * $brojDece;
    }

    public function posaljiEmailPotvrde(Rezervacija $rezervacija): void
    {
        $rezervacija->load(['putovanje', 'termin']);

        Mail::to($rezervacija->email)->send(new RezervacijaPotvrdaMail($rezervacija));
        Mail::to(config('mail.admin_address'))->send(new RezervacijaAdminMail($rezervacija));
    }
}
