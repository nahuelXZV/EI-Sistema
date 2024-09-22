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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->decimal('honorarios', 10, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->text('horario');
            $table->string('nro_preventiva');
            $table->boolean('pagado')->default(false);
            $table->string('dir_comprobante')->nullable();
            $table->string('nombre_comprobante')->nullable();
            $table->unsignedBigInteger('docente_id');
            $table->foreign('docente_id')->references('id')->on('teacher');
            $table->unsignedBigInteger('modulo_id')->nullable();
            $table->foreign('modulo_id')->references('id')->on('module');
            $table->unsignedBigInteger('curso_id')->nullable();
            $table->foreign('curso_id')->references('id')->on('course');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
