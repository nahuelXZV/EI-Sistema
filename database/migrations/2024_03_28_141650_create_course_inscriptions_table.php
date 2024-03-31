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
        Schema::create('course_inscription', function (Blueprint $table) {
            $table->id();
            $table->decimal('nota', 8, 2);
            $table->string('observacion');
            $table->string('fecha');
            $table->unsignedBigInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('course')->onDelete('cascade');
            $table->unsignedBigInteger('estudiante_id');
            $table->foreign('estudiante_id')->references('id')->on('student')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_inscription');
    }
};
