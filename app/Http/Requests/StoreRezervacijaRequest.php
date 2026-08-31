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
            'broj_pasosa' => 'nullable|string|max:50',
            'adresa' => 'nullable|string|max:255',
            'mesto' => 'nullable|string|max:100',
            'id_drzave' => 'nullable|exists:drzavas,id',
            'id_termina' => 'required|exists:terminis,id',
            'broj_odraslih' => 'required|integer|min:1',
            'broj_dece' => 'nullable|integer|min:0',
            'napomena' => 'nullable|string|max:1000',
            'id_putovanja' => 'required|exists:putovanjas,id',
            'id_hotela' => 'nullable|exists:hotels,id',
            'id_tip_sobe' => 'nullable|exists:tip_sobes,id',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'puno_ime.required' => 'Puno ime je obavezno.',
            'telefon.required' => 'Telefon je obavezan.',
            'email.required' => 'Email je obavezan.',
            'email.email' => 'Email mora biti validna email adresa.',
            'id_termina.required' => 'Termin je obavezan.',
            'id_termina.exists' => 'Izabrani termin ne postoji.',
            'broj_odraslih.required' => 'Broj odraslih je obavezan.',
            'broj_odraslih.min' => 'Broj odraslih mora biti najmanje 1.',
            'id_putovanja.required' => 'Putovanje je obavezno.',
            'id_putovanja.exists' => 'Izabrano putovanje ne postoji.',
        ];
    }
}
