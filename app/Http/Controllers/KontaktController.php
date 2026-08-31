<?php

namespace App\Http\Controllers;

use App\Mail\KontaktMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class KontaktController extends Controller
{
    public function posalji(Request $request)
    {
        $validated = $request->validate([
            'ime'     => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:150'],
            'telefon' => ['nullable', 'string', 'max:30'],
            'poruka'  => ['required', 'string', 'max:2000'],
        ]);

        Mail::to(config('mail.admin_address'))->send(
            new KontaktMail($validated['ime'], $validated['email'], $validated['telefon'] ?? '', $validated['poruka'])
        );

        return redirect()->route('pocetna')->with('kontakt_success', true)->withFragment('kontakt');
    }
}
