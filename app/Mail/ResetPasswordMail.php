<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use SerializesModels;

    public string $resetUrl;

    public function __construct(string $resetUrl)
    {
        $this->resetUrl = $resetUrl;
    }

    public function build(): static
    {
        return $this->subject(__('Reset lozinke'))
                    ->view('emails.reset-password');
    }
}
