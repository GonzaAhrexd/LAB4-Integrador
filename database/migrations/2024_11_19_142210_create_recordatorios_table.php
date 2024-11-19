<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateRecordatoriosTable extends Migration
{
    public function up()
    {
        Schema::create('recordatorios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarea_id')->constrained()->onDelete('cascade');
            $table->text('descripcion');
            $table->timestamp('fecha_hora');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recordatorios');
    }
}
