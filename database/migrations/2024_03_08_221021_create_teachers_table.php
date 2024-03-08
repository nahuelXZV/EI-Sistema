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
        Schema::create('teacher', function (Blueprint $table) {
            $table->id();
            $table->string('honorifico', 50);
            $table->string('nombre');
            $table->string('apellido');
            $table->string('foto')->nullable();
            $table->string('cv')->nullable();
            $table->string('cedula');
            $table->string('expedicion', 3);
            $table->string('telefono', 20)->nullable();
            $table->string('correo')->nullable();
            $table->boolean('factura')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher');
    }
};
