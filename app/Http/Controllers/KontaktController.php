<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKontaktRequest;
use App\Mail\KontaktMail;
use Illuminate\Support\Facades\Mail;

class KontaktController extends Controller
{
    public function posalji(StoreKontaktRequest $request)
    {
        $validated = $request->validated();

        Mail::to(config('mail.admin_adresa'))->send(
            new KontaktMail($validated['ime'], $validated['email'], $validated['telefon'] ?? '', $validated['poruka'])
        );

        return redirect()->route('pocetna')->with('kontakt_success', true)->withFragment('kontakt');
    }
}
