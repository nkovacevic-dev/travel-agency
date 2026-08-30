<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rezervacije extends Model
{
    use HasFactory;

    protected $fillable = [
        'puno_ime',
        'email',
        'telefon',
        'broj_pasosa',
        'adresa',
        'mesto',
        'id_drzave',
        'id_putovanja',
        'id_termina',
        'id_hotela',
        'id_tip_sobe',
        'broj_odraslih',
        'broj_dece',
        'status',
        'napomena',
        'ukupna_cena',
    ];

    protected $casts = [
        'broj_odraslih' => 'integer',
        'broj_dece' => 'integer',
        'ukupna_cena' => 'decimal:2',
    ];

    // Relacije
    public function putovanje()
    {
        return $this->belongsTo(Putovanje::class, 'id_putovanja');
    }

    public function termin()
    {
        return $this->belongsTo(Termin::class, 'id_termina');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'id_hotela');
    }

    public function tipSobe()
    {
        return $this->belongsTo(TipSobe::class, 'id_tip_sobe');
    }
}
