<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('module', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('nombre');
            $table->string('sigla', 20);
            $table->string('version', 20);
            $table->string('edicion', 20);
            $table->string('modalidad', 50);
            $table->string('estado', 30);
            $table->decimal('costo', 10, 2)->default(0);
            $table->integer('hrs_academicas')->default(0);
            $table->string('fecha_inicio', 20);
            $table->string('fecha_final', 20);
            $table->text('contenido');
            $table->decimal('calificacion_docente', 10, 2)->default(0);

            $table->unsignedBigInteger('programa_id');
            $table->foreign('programa_id')->references('id')->on('program')->onDelete('cascade');

            $table->unsignedBigInteger('docente_id');
            $table->foreign('docente_id')->references('id')->on('teacher')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module');
    }
};
