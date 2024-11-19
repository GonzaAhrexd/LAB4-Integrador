<?php

namespace App\Models;

class Proceso extends Tarea
{
    public function subtareas()
    {
        return $this->hasMany(Subtarea::class);
    }

    public function mostrarDetalles()
    {
        $subtareas = $this->subtareas->map(function ($subtarea) {
            return "{$subtarea->orden}. {$subtarea->nombre}";
        })->join(', ');

        return "Proceso con subtareas: {$subtareas}.";
    }
    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }
}

// Modelo de Subtarea
class Subtarea extends Model
{
    protected $fillable = ['nombre', 'orden', 'proceso_id'];

    public function proceso()
    {
        return $this->belongsTo(Proceso::class);
    }
    
}
