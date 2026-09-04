<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prevoznik extends Model
{
    protected $table = 'prevoznik';

    protected $fillable = [
        'naziv',
        'adresa',
        'grad',
        'id_tip_prevoza',
        'kontakt',
    ];

    public function tip_prevoza()
    {
        return $this->belongsTo(TipPrevoza::class);
    }
}
