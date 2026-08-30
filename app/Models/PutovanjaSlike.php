<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PutovanjaSlike extends Model
{
    protected $table = 'putovanja_slikas';
    protected $fillable = ['id_putovanja', 'slika'];

    public function putovanje()
    {
        return $this->belongsTo(Putovanje::class, 'id_putovanja');
    }
}
