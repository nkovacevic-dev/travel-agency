<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Termin extends Model
{
    protected $table = 'termini';

    protected $fillable = [
        'id_putovanja',
        'datum_od',
        'datum_do',
        'broj_dostupnih_mesta',
    ];

    protected $casts = [
        'datum_od' => 'date',
        'datum_do' => 'date',
        'broj_dostupnih_mesta' => 'integer',
    ];

    public function putovanje()
    {
        return $this->belongsTo(Putovanje::class, 'id_putovanja');
    }

    public function rezervacije()
    {
        return $this->hasMany(Rezervacija::class, 'id_termina');
    }
}
