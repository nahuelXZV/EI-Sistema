<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('program', function (Blueprint $table) {
            $table->boolean('esta_en_oferta')->default(false);
        });

        // nueva tabla pre-registro
        Schema::create('pre_registration', function (Blueprint $table) {
            $table->id();
            $table->string('honorifico');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('foto')->nullable();
            $table->string('cedula')->unique();
            $table->string('expedicion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->unique();
            $table->string('nro_registro')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('sexo')->nullable();

            $table->decimal('monto', 10, 2);
            $table->string("comprobante_pago")->nullable();
            $table->unsignedBigInteger('programa_id')->nullable();
            $table->foreign('programa_id')->references('id')->on('program');
            $table->unsignedBigInteger('descuento_id')->nullable();
            $table->foreign('descuento_id')->references('id')->on('discount_type');
            $table->unsignedBigInteger('tipo_pago_id');
            $table->foreign('tipo_pago_id')->references('id')->on('payment_type');

            $table->unsignedBigInteger('carrera_id')->nullable();
            $table->foreign('carrera_id')->references('id')->on('career');
            $table->unsignedBigInteger('universidad_id')->nullable();
            $table->foreign('universidad_id')->references('id')->on('university');

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::table('program', function (Blueprint $table) {
            $table->dropColumn('esta_en_oferta');
        });

        Schema::dropIfExists('pre_registration');
    }
};
