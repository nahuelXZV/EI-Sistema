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
        Schema::create('program_payments', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->decimal('convalidacion', 10, 2)->nullable();

            $table->unsignedBigInteger('estudiante_id');
            $table->foreign('estudiante_id')->references('id')->on('student');
            $table->unsignedBigInteger('programa_id');
            $table->foreign('programa_id')->references('id')->on('program');
            $table->unsignedBigInteger('tipo_descuento_id')->nullable();
            $table->foreign('tipo_descuento_id')->references('id')->on('discount_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_payments');
    }
};
