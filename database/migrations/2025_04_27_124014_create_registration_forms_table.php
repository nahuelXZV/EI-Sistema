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
        Schema::create('registration_forms', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('genero');
            $table->boolean("es_boliviano")->default(true);
            $table->string('ci')->nullable();
            $table->string('ci_expedido')->nullable();
            $table->string('pasaporte')->nullable();
            $table->string('telefono');
            $table->string('whatsapp');
            $table->string('email');
            $table->string('profesion');
            $table->string('universidad_origen');
            $table->string('anio_egreso');
            $table->string('registro_uagrm')->nullable();
            $table->string('institucion_trabajo');
            $table->string('url_foto');
            $table->text('experiencia_laboral');

            $table->unsignedBigInteger('programa_id');
            $table->foreign('programa_id')->references('id')->on('program');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_forms');
    }
};
