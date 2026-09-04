<?php

namespace App\Enums;

enum StatusRezervacije: string
{
    case Nova = 'nova';
    case Potvrdjena = 'potvrđena';
    case Otkazana = 'otkazana';

    public function label(): string
    {
        return match ($this) {
            self::Nova => 'Nova',
            self::Potvrdjena => 'Potvrđena',
            self::Otkazana => 'Otkazana',
        };
    }

    /** Bootstrap boja bedža za prikaz statusa. */
    public function boja(): string
    {
        return match ($this) {
            self::Nova => 'warning',
            self::Potvrdjena => 'success',
            self::Otkazana => 'danger',
        };
    }
}
