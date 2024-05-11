<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectsTable extends Migration
{
    public function up()
    {
        Schema::create('collects', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('id_vehicule');
            $table->foreign('id_vehicule')->references('id')->on('vehicules');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            $table->string('plan_de_route');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('collects');
    }
}