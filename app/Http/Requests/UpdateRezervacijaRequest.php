<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRezervacijaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check(); // Samo admin
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
            'telefon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'termin' => 'required|string|max:255',
            'broj_odraslih' => 'required|integer|min:1',
            'broj_dece' => 'nullable|integer|min:0',
            'napomena' => 'nullable|string|max:1000',
            'id_putovanja' => 'required|exists:putovanjas,id',
            'id_hotela' => 'nullable|exists:hotels,id',
            'id_tip_sobe' => 'nullable|exists:tip_sobes,id',
            'status' => 'nullable|string|in:nova,potvrđena,otkazana',
        ];
    }
}
