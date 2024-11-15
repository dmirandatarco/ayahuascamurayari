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
        Schema::create('detalle_operars', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('operar_id')-> unsigned();
            $table->foreign('operar_id')->references('id')->on('operars');
            $table->BigInteger('detalles_id')-> unsigned();
            $table->foreign('detalles_id')->references('id')->on('detalles');
            $table->time('horarecojo')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_operars');
    }
};
