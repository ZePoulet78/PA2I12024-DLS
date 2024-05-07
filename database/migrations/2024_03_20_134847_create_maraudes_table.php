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
        Schema::create('maraude', function (Blueprint $table) {
            $table->id();
            $table->date('maraud_date');
            $table->time('departure_time');
            $table->time('return_time');
            $table->string('itinerary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maraude');
    }
};
