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
        Schema::create('support_request', function (Blueprint $table) {
            $table->id();
            $table->string('motivo');
            $table->string('fecha');
            $table->string('hora');
            $table->string('estado');
            $table->text('descripcion');
            $table->string('recurso')->nullable();
            $table->string('fecha_visita')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_request');
    }
};
