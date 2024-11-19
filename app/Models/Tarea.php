<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Tarea extends Model
{
    protected $fillable = ['tipo', 'nombre', 'descripcion', 'fecha', 'estado'];

    // Método abstracto para implementar en subclases
    abstract public function mostrarDetalles();
}

