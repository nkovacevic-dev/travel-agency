<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PutovanjeSlika extends Model
{
    protected $table = 'putovanje_slika';
    protected $fillable = ['id_putovanja', 'slika'];

    public function putovanje()
    {
        return $this->belongsTo(Putovanje::class, 'id_putovanja');
    }
}
