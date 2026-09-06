<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected function validationErrorMessages()
    {
        return [
            'email.required' => 'Email adresa je obavezna.',
            'email.email' => 'Unesite ispravnu email adresu.',
            'password.required' => 'Nova lozinka je obavezna.',
            'password.confirmed' => 'Lozinke se ne podudaraju.',
            'password.min' => 'Lozinka mora imati najmanje 8 karaktera.',
            'token.required' => 'Token je obavezan.',
        ];
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';
}
