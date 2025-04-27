<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program', function (Blueprint $table) {
            $table->boolean('inscripcion_habilitado')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('program', function (Blueprint $table) {
            $table->dropColumn('inscripcion_habilitado');
        });
    }
};
