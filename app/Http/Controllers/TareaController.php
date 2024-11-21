<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacto;
use App\Models\Proceso;
use App\Models\Recordatorio;

class TareaController extends Controller
{
    /**
     * Listar todas las tareas (Index)
     */
    public function index()
    {
        // Combinar todas las tareas de los tres modelos
        $tareas = Contacto::all()
            ->merge(Proceso::with('subtareas')->get()) // Traer subtareas con procesos
            ->merge(Recordatorio::all());

        return response()->json($tareas);
    }

    /**
     * Crear una nueva tarea (Store)
     */
    public function store(Request $request)
{
    // Muestra en el cmd un mensaje de que se esta creando una tarea
    echo "Creando tarea...";

    $tipo = $request->input('tipo');

    // Validar el tipo de tarea
    if (!in_array($tipo, ['contacto', 'proceso', 'recordatorio'])) {
        return response()->json(['error' => 'Tipo de tarea no válido'], 400);
    }

    // Crear la tarea de acuerdo con el tipo
    $tarea = null;

    // Crear la tarea dependiendo del tipo
    switch ($tipo) {
        case 'contacto':
            // Crear la tarea de tipo Contacto
            $tarea = Contacto::create([ // Aquí estás creando una tarea en la tabla 'contactos'
                'tipo' => 'contacto',
                'nombre' => $request->input('nombre'),
                'descripcion' => 'Contacto relacionado',
                'razon' => $request->input('razon'),
                'telefono' => $request->input('telefono'),
                'email' => $request->input('email'),
                'fecha' => now(),
                'estado' => 'pendiente',
            ]);
            break;
        case 'proceso':
            // Crear la tarea de tipo Proceso
            $tarea = Proceso::create([ // Crear tarea en la tabla 'tareas'
                'tipo' => 'proceso',
                'nombre' => $request->input('nombre'),
                'descripcion' => $request->input('descripcion'),
                'fecha' => now(),
                'estado' => 'pendiente',
            ]);
            break;
        case 'recordatorio':
            // Crear la tarea de tipo Recordatorio
            $tarea = Recordatorio::create([ // Crear tarea en la tabla 'tareas'
                'tipo' => 'recordatorio',
                'nombre' => $request->input('nombre'),
                'descripcion' => $request->input('descripcion'),
                'fecha' => $request->input('fecha'),
                'estado' => 'pendiente',
            ]);
            break;
    }

    // Verificar si la tarea se creó correctamente
    if ($tarea) {
        // Crear el contacto (o cualquier otro registro relacionado) ahora que tenemos el ID de la tarea
        if ($tipo === 'contacto') {
            Contacto::create([
                'tarea_id' => $tarea->id, // Asociamos el ID de la tarea con el contacto
                'nombre' => $request->input('nombre'),
                'razon' => $request->input('razon'),
                'telefono' => $request->input('telefono'),
                'email' => $request->input('email'),
            ]);
        }

        // Para procesos, agregar subtareas si las hay
        if ($tipo === 'proceso' && $request->has('subtareas')) {
            foreach ($request->input('subtareas') as $subtarea) {
                $tarea->subtareas()->create([
                    'nombre' => $subtarea['nombre'],
                    'orden' => $subtarea['orden'],
                ]);
            }
        }

        return response()->json([
            'message' => 'Tarea creada con éxito',
            'tarea' => $tarea,
        ]);
    }

    return response()->json(['error' => 'Error al crear la tarea'], 500);
}


    /**
     * Mostrar detalles de una tarea específica (Show)
     */
    public function show($id, $tipo)
    {
        $model = $this->getModelByType($tipo);

        if (!$model) {
            return response()->json(['error' => 'Tipo de tarea no válido'], 400);
        }

        $tarea = $model::find($id);

        if (!$tarea) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        return response()->json($tarea);
    }

    /**
     * Actualizar una tarea existente (Update)
     */
    public function update(Request $request, $id, $tipo)
    {
        $model = $this->getModelByType($tipo);

        if (!$model) {
            return response()->json(['error' => 'Tipo de tarea no válido'], 400);
        }

        $tarea = $model::find($id);

        if (!$tarea) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        $tarea->update($request->all());

        return response()->json([
            'message' => 'Tarea actualizada con éxito',
            'tarea' => $tarea,
        ]);
    }

    /**
     * Eliminar una tarea (Destroy)
     */
    public function destroy($id, $tipo)
    {
        $model = $this->getModelByType($tipo);

        if (!$model) {
            return response()->json(['error' => 'Tipo de tarea no válido'], 400);
        }

        $tarea = $model::find($id);

        if (!$tarea) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        $tarea->delete();

        return response()->json(['message' => 'Tarea eliminada con éxito']);
    }

    /**
     * Método privado para obtener el modelo según el tipo
     */
    private function getModelByType($tipo)
    {
        return match ($tipo) {
            'contacto' => Contacto::class,
            'proceso' => Proceso::class,
            'recordatorio' => Recordatorio::class,
            default => null,
        };
    }
}

