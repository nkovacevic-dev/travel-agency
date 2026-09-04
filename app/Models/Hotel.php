<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotel';

    protected $fillable = [
        'naziv',
        'broj_zvezdica',
        'adresa',
        'grad',
        'id_drzave',
        'telefon',
        'email',
        'opis',
    ];

    public function drzava() {
        return $this->belongsTo(Drzava::class);
    }
}
