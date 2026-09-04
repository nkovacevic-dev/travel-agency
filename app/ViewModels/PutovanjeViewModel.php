<?php

namespace App\ViewModels;

use App\Models\Putovanje;

class PutovanjeViewModel
{
    public function __construct(private Putovanje $putovanje) {}

    public function putovanje(): Putovanje
    {
        return $this->putovanje;
    }

    public function termini(): array
    {
        return $this->putovanje->termini->map(fn($termin) => [
            'id' => $termin->id,
            'datum_od' => $termin->datum_od->format('d.m.Y.'),
            'datum_do' => $termin->datum_do->format('d.m.Y.'),
            'broj_dostupnih_mesta' => $termin->broj_dostupnih_mesta,
        ])->toArray();
    }
}
