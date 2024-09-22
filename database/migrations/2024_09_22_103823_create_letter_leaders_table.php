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
        Schema::create('letter_leaders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('letter_id');
            $table->foreign('letter_id')->references('id')->on('letters');
            $table->unsignedBigInteger('leader_id');
            $table->foreign('leader_id')->references('id')->on('leaders');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_leaders');
    }
};
