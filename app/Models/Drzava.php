<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drzava extends Model
{
    use HasFactory;

    protected $table = 'drzava';

    protected $fillable = [
        'naziv'
    ];
}
