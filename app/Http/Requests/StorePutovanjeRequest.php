<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePutovanjeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'naziv' => 'required|string|max:255',
            'id_drzave' => 'required|exists:drzavas,id',
            'grad' => 'required|string|max:255',
            'mesto_polaska' => 'required|string|max:255',
            'datum_od' => 'required|date',
            'datum_do' => 'required|date|after_or_equal:datum_od',
            'broj_dana' => 'required|integer|min:1',
            'broj_nocenja' => 'required|integer|min:0',
            'broj_dostupnih_mesta' => 'required|integer|min:1',
            'broj_rezervacija' => 'nullable|integer|min:0',
            'cena' => 'required|numeric|min:0',
            'id_hotel' => 'nullable',
            'id_tip_prevoza' => 'required',
            'prevoznik' => 'nullable|string|max:255',
            'program_putovanja' => 'required|string',
            'fakultativni_izleti' => 'nullable|string',
            'pravila_otkazivanja' => 'nullable|string',
            'baner_slika' => 'nullable|string|max:255',
            'galerija_slika' => 'nullable|array',
        ];
    }

    public function messages()
    {
        return [
            'naziv.required' => __('Polje naziv je obavezno.'),
            'id_drzave.required' => __('Polje država je obavezno.'),
            'id_drzave.exists' => __('Izabrana država ne postoji.'),
            'grad.required' => __('Polje grad je obavezno.'),
            'mesto_polaska.required' => __('Polje mesto polaska je obavezno.'),
            'datum_od.required' => __('Polje datum od je obavezno.'),
            'datum_do.required' => __('Polje datum do je obavezno.'),
            'datum_do.after_or_equal' => __('Datum do mora biti isti ili posle datuma od.'),
            'broj_dana.required' => __('Polje broj dana je obavezno.'),
            'broj_nocenja.required' => __('Polje broj noćenja je obavezno.'),
            'broj_dostupnih_mesta.required' => __('Polje broj dostupnih mesta je obavezno.'),
            'cena.required' => __('Polje cena po osobi je obavezno.'),
            'id_tip_prevoza.required' => __('Polje tip prevoza je obavezno.'),
            'program_putovanja.required' => __('Polje program putovanja je obavezno.'),
        ];
    }
}
