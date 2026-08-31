<?php

namespace App\Mail;

use App\Models\Rezervacije;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RezervacijaAdminMail extends Mailable
{
    use SerializesModels;

    public Rezervacije $rezervacija;

    public function __construct(Rezervacije $rezervacija)
    {
        $this->rezervacija = $rezervacija;
    }

    public function build(): static
    {
        return $this->subject('Nova rezervacija — ' . $this->rezervacija->putovanje->naziv)
                    ->view('emails.rezervacija_admin');
    }
}
