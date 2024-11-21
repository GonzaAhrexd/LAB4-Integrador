<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;

Route::get('/', function () {
    return view('index');
});


Route::get('/tareas', [TareaController::class, 'index']);
Route::post('/tareas', [TareaController::class, 'store']);
Route::get('/tareas/{tipo}/{id}', [TareaController::class, 'show']);
Route::put('/tareas/{tipo}/{id}', [TareaController::class, 'update']);
Route::delete('/tareas/{tipo}/{id}', [TareaController::class, 'destroy']);
