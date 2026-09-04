<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKorisnikRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id') ?? $this->user()?->id;

        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:korisnik,email,' . $id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Polje ime je obavezno.',
            'email.required'    => 'Polje email je obavezno.',
            'email.email'       => 'Polje email mora biti ispravna email adresa.',
            'email.unique'      => 'Korisnik sa ovim email-om već postoji.',
            'password.min'      => 'Lozinka mora imati najmanje 8 karaktera.',
            'password.confirmed'=> 'Lozinke se ne podudaraju.',
        ];
    }
}
