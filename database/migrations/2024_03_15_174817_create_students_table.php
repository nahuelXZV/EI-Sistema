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
        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->string('honorifico');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('foto')->nullable();
            $table->string('cedula')->unique();
            $table->string('expedicion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->unique();
            $table->string('estado')->default('activo');
            $table->string('fecha_inactividad')->nullable();
            $table->string('nro_registro')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('sexo')->nullable();

            $table->unsignedBigInteger('carrera_id')->nullable();
            $table->foreign('carrera_id')->references('id')->on('career');
            $table->unsignedBigInteger('universidad_id')->nullable();
            $table->foreign('universidad_id')->references('id')->on('university');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};
