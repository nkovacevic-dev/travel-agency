<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ], [
            $this->username() . '.required' => __('Polje elektronska pošta je obavezno.'),
            $this->username() . '.string'   => __('Email adresa mora biti tekst.'),
            'password.required'             => __('Polje šifra je obavezno.'),
            'password.string'               => __('Šifra mora biti tekst.'),
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [__('Pogrešna elektronska pošta ili šifra.')],
        ]);
    }
}
