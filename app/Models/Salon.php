<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salon extends Model
{
    use SoftDeletes;

    protected $table = 'salones';

    // Timestamps enabled by default. created_at exists, updated_at added in migration.

    protected $fillable = [
        'codigo',
        'edificio',
        'capacidad',
        'nombre',
        'tipo',
        'estado'
    ];
}
