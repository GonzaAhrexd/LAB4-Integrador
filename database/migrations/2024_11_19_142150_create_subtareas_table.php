<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateSubtareasTable extends Migration
{
    public function up()
    {
        Schema::create('subtareas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proceso_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->integer('orden');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subtareas');
    }
}
