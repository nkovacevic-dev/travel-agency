<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rezervacije extends Model
{
    use HasFactory;

    protected $fillable = [
        'puno_ime',
        'telefon',
        'termin',
        'broj_odraslih',
        'broj_dece',
        'email',
        'napomena',
        'id_putovanja',
        'id_hotela',
        'id_tip_sobe',
        'status',
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

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'id_hotela');
    }

    public function tipSobe()
    {
        return $this->belongsTo(TipSobe::class, 'id_tip_sobe');
    }
}
