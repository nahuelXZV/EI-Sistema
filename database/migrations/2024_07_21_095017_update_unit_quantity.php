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
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('cantidad');
            $table->dropColumn('unidad_medida');

            $table->integer('cantidad_contenedor')->default(0)->nullable();
            $table->integer('unidades_contenedor')->default(0)->nullable();
            $table->integer('total_unidades')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->integer('cantidad')->nullable();
            $table->string('unidad_medida')->nullable();

            $table->dropColumn('cantidad_contenedor');
            $table->dropColumn('unidades_contenedor');
            $table->dropColumn('total_unidades');
        });
    }
};
