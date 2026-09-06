<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email'], [
            'email.required' => 'Email adresa je obavezna.',
            'email.email' => 'Unesite ispravnu email adresu.',
        ]);
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('status', __('Poslali smo vam link za reset lozinke na email.'));
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Ne postoji korisnik sa ovom email adresom.']);
    }
}
