<?php


namespace App\Models;

class Contacto extends Tarea
{
    protected $fillable = ['nombre', 'razon', 'telefono', 'email'];

    public function mostrarDetalles()
    {
        return "Contacto: {$this->nombre} para {$this->razon}. Teléfono: {$this->telefono}, Email: {$this->email}";
    }
    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }
}
