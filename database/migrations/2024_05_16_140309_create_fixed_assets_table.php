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
        Schema::create('fixed_asset', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('codigo');
            $table->string('nombre');
            $table->string('tipo');
            $table->string('modelo')->nullable();
            $table->integer('cantidad');
            $table->string('estado');
            $table->text('descripcion')->nullable();
            $table->string('unidad')->nullable();

            $table->unsignedBigInteger('encargado_id')->nullable();
            $table->foreign('encargado_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('area');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_asset');
    }
};
