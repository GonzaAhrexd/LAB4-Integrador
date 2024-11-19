<?php

namespace App\Models;

class Recordatorio extends Tarea
{
    protected $fillable = ['descripcion', 'fecha_hora'];

    public function mostrarDetalles()
    {
        return "Recordatorio: {$this->descripcion} en {$this->fecha_hora}.";
    }
    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }
}
