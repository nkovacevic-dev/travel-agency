<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKontaktRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ime'     => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:150'],
            'telefon' => ['nullable', 'string', 'max:30'],
            'poruka'  => ['required', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'ime.required'    => 'Polje ime i prezime je obavezno.',
            'ime.max'         => 'Ime i prezime ne sme biti duže od 100 karaktera.',
            'email.required'  => 'Polje email adresa je obavezno.',
            'email.email'     => 'Unesite ispravnu email adresu.',
            'email.max'       => 'Elektronska pošta ne sme biti duža od 150 karaktera.',
            'telefon.max'     => 'Broj telefona ne sme biti duži od 30 karaktera.',
            'poruka.required' => 'Polje poruka je obavezno.',
            'poruka.max'      => 'Poruka ne sme biti duža od 2000 karaktera.',
        ];
    }

    // Vraća na #kontakt sekciju umjesto na vrh stranice
    protected function getRedirectUrl(): string
    {
        return parent::getRedirectUrl() . '#kontakt';
    }
}
