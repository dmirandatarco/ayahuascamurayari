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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('imagenprincipal',300)->nullable();
            $table->string('titulo',300)->nullable();
            $table->string('slug',350)->nullable();
            $table->date('fecha')->nullable();
            $table->BigInteger('user_id')-> unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('descripcioncorta')->nullable();
            $table->text('descripcionlarga')->nullable();
            $table->BigInteger('language_id')->unsigned()->nullable();
            $table->foreign('language_id')->references('id')->on('languages');
            $table->boolean('nosotros')->default(0);  //1 va en nosotros  0 no va
            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('blogs');
    }
};
