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
        Schema::create('process_done', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->unsignedBigInteger('proceso_modulo_id');
            $table->unsignedBigInteger('modulo_id');
            $table->foreign('proceso_modulo_id')->references('id')->on('module_process')->onDelete('cascade');;
            $table->foreign('modulo_id')->references('id')->on('module')->onDelete('cascade');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_done');
    }
};
