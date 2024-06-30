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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('codigo_partida');
            $table->string('codigo_catalogo');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('tipo');
            $table->integer('cantidad');
            $table->string('estado');
            $table->string('unidad_medida')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
