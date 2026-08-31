<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KontaktMail extends Mailable
{
    use SerializesModels;

    public string $imePosiljaoca;
    public string $emailPosiljaoca;
    public string $telefon;
    public string $poruka;

    public function __construct(string $ime, string $email, string $telefon, string $poruka)
    {
        $this->imePosiljaoca = $ime;
        $this->emailPosiljaoca = $email;
        $this->telefon = $telefon;
        $this->poruka = $poruka;
    }

    public function build(): static
    {
        return $this->subject('Nova poruka sa kontakt forme — ' . $this->imePosiljaoca)
                    ->replyTo($this->emailPosiljaoca, $this->imePosiljaoca)
                    ->view('emails.kontakt');
    }
}
