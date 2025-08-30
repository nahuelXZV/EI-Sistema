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
        Schema::create('program', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->string('nombre');
            $table->string('sigla', 20);
            $table->string('version', 20);
            $table->string('edicion', 20);
            $table->string('tipo', 50);
            $table->string('modalidad', 50);
            $table->string('fecha_inicio', 20);
            $table->string('fecha_final', 20);
            $table->decimal('costo', 10, 2)->default(0);
            $table->integer('hrs_academicas')->default(0);
            $table->boolean('has_grafica')->default(false);
            $table->boolean('has_editable')->default(false);
            $table->integer('cantidad_modulos')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program');
    }
};
