<?php

namespace App\Support;

use Illuminate\Support\Collection;

/** Pretvara Eloquent kolekcije u niz opcija za select2 padajuće liste. */
class SelectOptions
{
    public static function odNaziva(Collection $stavke): array
    {
        return $stavke->map(fn($stavka) => ['id' => $stavka->id, 'text' => $stavka->naziv])->toArray();
    }
}
