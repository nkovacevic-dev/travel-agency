<?php

namespace App\Services;

use App\Mail\RezervacijaAdminMail;
use App\Mail\RezervacijaPotvrdaMail;
use App\Models\Putovanje;
use App\Models\Rezervacije;
use Illuminate\Support\Facades\Mail;

class RezervacijeService
{
    public function izracunajCenu(Putovanje $putovanje, int $brojOdraslih, int $brojDece): float
    {
        return $putovanje->cena * $brojOdraslih + ($putovanje->cena * 0.5) * $brojDece;
    }

    public function posaljiEmailPotvrde(Rezervacije $rezervacija): void
    {
        $rezervacija->load(['putovanje', 'termin']);

        Mail::to($rezervacija->email)->send(new RezervacijaPotvrdaMail($rezervacija));
        Mail::to(config('mail.admin_address'))->send(new RezervacijaAdminMail($rezervacija));
    }
}
