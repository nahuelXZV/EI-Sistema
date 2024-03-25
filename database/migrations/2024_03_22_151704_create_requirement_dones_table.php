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
        Schema::create('requirement_done', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('nombre');
            $table->string('documento');
            $table->unsignedBigInteger('requisito_registro_id');
            $table->unsignedBigInteger('estudiante_id');
            $table->foreign('requisito_registro_id')->references('id')->on('registration_requirement')->onDelete('cascade');
            $table->foreign('estudiante_id')->references('id')->on('student')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirement_done');
    }
};
