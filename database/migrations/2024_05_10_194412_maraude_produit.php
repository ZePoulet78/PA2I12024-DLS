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
        Schema::create('maraude_produit', function (Blueprint $table) {
            $table->unsignedBigInteger('maraude_id');
            $table->unsignedBigInteger('produit_id');
            $table->unsignedInteger('quantity');

            $table->primary(['maraude_id', 'produit_id']);

            $table->foreign('maraude_id')->references('id')->on('maraude')->onDelete('cascade');
            $table->foreign('produit_id')->references('id')->on('produit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
