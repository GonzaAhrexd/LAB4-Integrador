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
  
        $tipo = $request->input('tipo');

        // Validar el tipo de tarea
        if (!in_array($tipo, ['contacto', 'proceso', 'recordatorio'])) {
            return response()->json(['error' => 'Tipo de tarea no válido'], 400);
        }

        // Crear la tarea según el tipo
        $tarea = match ($tipo) {
            'contacto' => Contacto::create([
                'nombre' => $request->input('nombre'),
                'razon' => $request->input('razon'),
                'telefono' => $request->input('telefono'),
                'email' => $request->input('email'),
            ]),
            'proceso' => Proceso::create([]), // Crear proceso vacío
            'recordatorio' => Recordatorio::create([
                'descripcion' => $request->input('descripcion'),
                'fecha_hora' => $request->input('fecha_hora'),
            ]),
        };

        // Para procesos, agregar subtareas
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

