<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vitacora extends Model
{
    protected $table = 'vitacora';

    protected $fillable = ['usuario', 'accion', 'hora'];

    protected $casts = [
        'hora' => 'datetime',
    ];
}
