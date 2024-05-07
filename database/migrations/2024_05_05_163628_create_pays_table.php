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
        Schema::create('pay', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 10, 2);
            $table->string('fecha');
            $table->string('hora');
            $table->string('comprobante')->nullable();
            $table->text('observacion')->nullable();

            $table->unsignedBigInteger('programa_pago_id')->nullable();
            $table->foreign('programa_pago_id')->references('id')->on('program_payments');

            $table->unsignedBigInteger('curso_pago_id')->nullable();
            $table->foreign('curso_pago_id')->references('id')->on('course_payments');

            $table->unsignedBigInteger('tipo_pago_id');
            $table->foreign('tipo_pago_id')->references('id')->on('payment_type');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay');
    }
};
