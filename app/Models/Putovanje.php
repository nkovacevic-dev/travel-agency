<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Putovanje extends Model
{
    use HasFactory;
    protected $table = 'putovanje';
    protected $fillable = [
        'naziv',
        'id_drzave',
        'grad',
        'broj_dana',
        'broj_nocenja',
        'cena',
        'id_hotela',
        'id_tip_prevoza',
        'prevoznik',
        'program_putovanja',
        'broj_rezervacija',
        'fakultativni_izleti',
        'pravila_otkazivanja',
    ];

    protected $casts = [
        'broj_dana' => 'integer',
        'broj_nocenja' => 'integer',
        'broj_rezervacija' => 'integer',
        'cena' => 'decimal:2',
    ];

    // Relacije
    public function drzava()
    {
        return $this->belongsTo(Drzava::class, 'id_drzave');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'id_hotela');
    }

    public function tipPrevoza()
    {
        return $this->belongsTo(TipPrevoza::class, 'id_tip_prevoza');
    }

    public function termini()
    {
        return $this->hasMany(Termin::class, 'id_putovanja')->orderBy('datum_od');
    }

    public function rezervacije()
    {
        return $this->hasMany(Rezervacija::class, 'id_putovanja');
    }

    public function slike()
    {
        return $this->hasMany(PutovanjeSlika::class, 'id_putovanja');
    }
}
