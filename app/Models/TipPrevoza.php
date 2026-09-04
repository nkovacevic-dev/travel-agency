<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipPrevoza extends Model
{  
    protected $table = 'tip_prevoza';

    protected $fillable = [
      'naziv'
    ];
}
