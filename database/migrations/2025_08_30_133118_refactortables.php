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
        Schema::table('registration_requirement', function (Blueprint $table) {
            $table->dropColumn('importancia');
            $table->boolean("requerido")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registration_requirement', function (Blueprint $table) {
            $table->string('importancia')->default('');
            $table->dropColumn('requerido');
        });
    }
};
