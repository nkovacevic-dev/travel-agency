<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Putovanje;

class PutovanjeController extends Controller
{
    public function detalji(string $id)
    {
        $putovanje = Putovanje::with('termini')->findOrFail($id);

        $termini = $putovanje->termini->map(fn($t) => [
            'id'   => $t->id,
            'text' => $t->datum_od->format('d.m.Y.') . ' - ' . $t->datum_do->format('d.m.Y.') . ' (' . $t->broj_dostupnih_mesta . ' mesta)',
        ]);

        $hoteli = Hotel::where('id_drzave', $putovanje->id_drzave)->get()->map(fn($h) => [
            'id'   => $h->id,
            'text' => $h->naziv,
        ]);

        return response()->json([
            'termini'    => $termini,
            'hoteli'     => $hoteli,
            'id_hotela'  => $putovanje->id_hotela,
            'id_drzave'  => $putovanje->id_drzave,
        ]);
    }
}
