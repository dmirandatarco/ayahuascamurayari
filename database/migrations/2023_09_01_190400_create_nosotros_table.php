<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nosotros', function (Blueprint $table) {
            $table->id();

            $table->BigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->BigInteger('language_id')->unsigned()->nullable();
            $table->foreign('language_id')->references('id')->on('languages');
            $table->text('image_principal')->nullable();
            $table->text('image_secundaria')->nullable();
            $table->string('titulo');
            $table->text('subtitulo');
            $table->text('descripcion');
            $table->text('descripcion1');
            $table->text('descripcion2');
            $table->text('descripcion3');
            $table->integer('num_viajes');
            $table->integer('num_clientes');
            $table->integer('num_miembros');
            $table->integer('num_reconocimientos');
            $table->string('estado',1)->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nosotros');
    }
};
