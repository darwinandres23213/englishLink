<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivele extends Model{
    use HasFactory;

    protected $table = 'niveles';
    protected $primaryKey = 'id_nivel';

    protected $fillable = [
        'nombre_nivel',
    ];
}
