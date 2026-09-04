<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRezervacijaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'puno_ime' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefon' => 'required|string|max:20',
            'broj_pasosa' => 'required|string|max:50',
            'adresa' => 'required|string|max:255',
            'mesto' => 'required|string|max:100',
            'id_drzave' => 'required|exists:drzava,id',
            'id_termina' => 'required|exists:terminis,id',
            'broj_odraslih' => 'required|integer|min:1',
            'broj_dece' => 'nullable|integer|min:0',
            'napomena' => 'nullable|string|max:1000',
            'id_putovanja' => 'required|exists:putovanje,id',
            'id_hotela' => 'nullable|exists:hotel,id',
            'id_tip_sobe' => 'nullable|exists:tip_sobe,id',
            'status' => 'nullable|string|in:nova,potvrđena,otkazana',
        ];
    }

    public function messages(): array
    {
        return [
            'puno_ime.required'      => 'Polje ime i prezime je obavezno.',
            'puno_ime.max'           => 'Polje ime i prezime ne sme biti duže od 255 karaktera.',
            'telefon.required'       => 'Polje telefon je obavezno.',
            'email.required'         => 'Polje email je obavezno.',
            'email.email'            => 'Polje email mora biti ispravna email adresa.',
            'id_termina.required'    => 'Polje termin je obavezno.',
            'id_termina.exists'      => 'Izabrani termin ne postoji.',
            'broj_odraslih.required' => 'Polje broj odraslih je obavezno.',
            'broj_odraslih.integer'  => 'Polje broj odraslih mora biti ceo broj.',
            'broj_odraslih.min'      => 'Polje broj odraslih mora biti najmanje 1.',
            'id_putovanja.required'  => 'Polje putovanje je obavezno.',
            'id_putovanja.exists'    => 'Izabrano putovanje ne postoji.',
            'broj_pasosa.required'   => 'Polje broj pasoša je obavezno.',
            'adresa.required'        => 'Polje adresa je obavezno.',
            'mesto.required'         => 'Polje mesto je obavezno.',
            'id_drzave.required'     => 'Polje država je obavezno.',
            'id_drzave.exists'       => 'Izabrana država ne postoji.',
            'status.in'              => 'Polje status mora biti: nova, potvrđena ili otkazana.',
        ];
    }
}
