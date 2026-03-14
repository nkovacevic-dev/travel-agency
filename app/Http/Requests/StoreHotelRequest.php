<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHotelRequest extends FormRequest
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
            'broj_zvezdica' => 'nullable|integer|min:1|max:5',
            'adresa' => 'required|string|max:255',
            'grad' => 'required|string|max:255',
            'id_drzave' => 'required|string|max:255',
            'telefon' => 'required_without:email|nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'opis' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'naziv.required' => __('Polje naziv hotela je obavezno.'),
            'adresa.required' => __('Polje adresa je obavezno.'),
            'grad.required' => __('Polje grad je obavezno.'),
            'id_drzave.required' => __('Polje država je obavezno.'),
            'broj_zvezdica.integer' => __('Polje broj zvezdica mora biti broj.'),
            'broj_zvezdica.min' => __('Minimalan broj zvezdica je 1.'),
            'broj_zvezdica.max' => __('Maksimalan broj zvezdica je 5.'),
            'telefon.required_without' => __('Polje telefon je obavezno ako email nije unet.'),
            'email.email' => __('Unesite ispravnu email adresu.'),
        ];
    }
}
