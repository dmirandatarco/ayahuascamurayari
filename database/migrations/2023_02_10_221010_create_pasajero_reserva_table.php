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
        Schema::create('pasajero_reserva', function (Blueprint $table) {
            $table->BigInteger('pasajero_id')-> unsigned();
            $table->foreign('pasajero_id')->references('id')->on('pasajeros');
            $table->BigInteger('reserva_id')-> unsigned();
            $table->foreign('reserva_id')->references('id')->on('reservas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pasajero_reserva');
    }
};
