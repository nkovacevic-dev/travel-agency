<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRezervacijaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Javno dostupno
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
            'broj_pasosa' => [$this->user() ? 'required' : 'nullable', 'string', 'max:50'],
            'adresa'      => [$this->user() ? 'required' : 'nullable', 'string', 'max:255'],
            'mesto'       => [$this->user() ? 'required' : 'nullable', 'string', 'max:100'],
            'id_drzave'   => [$this->user() ? 'required' : 'nullable', 'exists:drzava,id'],
            'id_termina' => 'required|exists:terminis,id',
            'broj_odraslih' => 'required|integer|min:1',
            'broj_dece' => 'nullable|integer|min:0',
            'napomena' => 'nullable|string|max:1000',
            'id_putovanja' => 'required|exists:putovanje,id',
            'id_hotela' => 'nullable|exists:hotel,id',
            'id_tip_sobe' => 'nullable|exists:tip_sobe,id',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'puno_ime.required'      => 'Polje ime i prezime je obavezno.',
            'puno_ime.max'           => 'Polje ime i prezime ne sme biti duže od 255 karaktera.',
            'telefon.required'       => 'Polje telefon je obavezno.',
            'telefon.max'            => 'Polje telefon ne sme biti duže od 20 karaktera.',
            'email.required'         => 'Polje email je obavezno.',
            'email.email'            => 'Polje email mora biti ispravna email adresa.',
            'email.max'              => 'Polje email ne sme biti duže od 255 karaktera.',
            'id_termina.required'    => 'Polje termin je obavezno.',
            'id_termina.exists'      => 'Izabrani termin ne postoji.',
            'broj_odraslih.required' => 'Polje broj odraslih je obavezno.',
            'broj_odraslih.integer'  => 'Polje broj odraslih mora biti ceo broj.',
            'broj_odraslih.min'      => 'Polje broj odraslih mora biti najmanje 1.',
            'broj_dece.integer'      => 'Polje broj dece mora biti ceo broj.',
            'broj_dece.min'          => 'Polje broj dece ne može biti negativno.',
            'id_putovanja.required'  => 'Polje putovanje je obavezno.',
            'id_putovanja.exists'    => 'Izabrano putovanje ne postoji.',
            'broj_pasosa.required'   => 'Polje broj pasoša je obavezno.',
            'broj_pasosa.max'        => 'Polje broj pasoša ne sme biti duže od 50 karaktera.',
            'adresa.required'        => 'Polje adresa je obavezno.',
            'adresa.max'             => 'Polje adresa ne sme biti duže od 255 karaktera.',
            'mesto.required'         => 'Polje mesto je obavezno.',
            'mesto.max'              => 'Polje mesto ne sme biti duže od 100 karaktera.',
            'id_drzave.required'     => 'Polje država je obavezno.',
            'id_drzave.exists'       => 'Izabrana država ne postoji.',
            'napomena.max'           => 'Polje napomena ne sme biti duže od 1000 karaktera.',
        ];
    }
}
