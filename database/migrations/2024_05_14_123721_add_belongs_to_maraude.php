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
        Schema::table('produit', function (Blueprint $table) {
            $table->foreignId('belongs_to_maraude')
                  ->after('id')
                  ->nullable()
                  ->constrained('maraude')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produit', function (Blueprint $table) {
            $table->dropForeign(['belongs_to_maraude']);
            $table->dropColumn('belongs_to_maraude');
        });
    }
};
