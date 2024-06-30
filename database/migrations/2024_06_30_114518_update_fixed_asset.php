<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fixed_asset', function (Blueprint $table) {
            $table->dropColumn('unidad');
            $table->unsignedBigInteger('unidad_id')->nullable();
            $table->foreign('unidad_id')->references('id')->on('units');
        });
    }

    public function down(): void
    {
        Schema::table('fixed_asset', function (Blueprint $table) {
            $table->string('unidad')->nullable();
            $table->dropForeign(['unidad_id']);
            $table->dropColumn('unidad_id');
        });
    }
};
