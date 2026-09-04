<?php

namespace App\Mail;

use App\Models\Rezervacija;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RezervacijaPotvrdaMail extends Mailable
{
    use SerializesModels;

    public Rezervacija $rezervacija;

    public function __construct(Rezervacija $rezervacija)
    {
        $this->rezervacija = $rezervacija;
    }

    public function build(): static
    {
        return $this->subject('Potvrda rezervacije — ' . $this->rezervacija->putovanje->naziv)
                    ->view('emails.rezervacija_potvrda');
    }
}
