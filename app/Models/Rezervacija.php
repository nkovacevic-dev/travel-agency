<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rezervacija extends Model
{
    use HasFactory;

    protected $table = 'rezervacija';

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
        'cancel_token',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->cancel_token ??= \Illuminate\Support\Str::uuid()->toString();
        });
    }

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
