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
        Schema::create('produit', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity');
            $table->date('expiration_date');
            $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('cascade');
            $table->boolean('belongs_to_maraude')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produit');
    }
};
