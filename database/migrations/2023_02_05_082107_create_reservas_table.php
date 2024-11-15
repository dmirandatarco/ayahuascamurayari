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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('pasajero_id')-> unsigned();
            $table->foreign('pasajero_id')->references('id')->on('pasajeros');
            $table->BigInteger('user_id')-> unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->BigInteger('proveedor_id')-> unsigned()->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
            $table->dateTime('fecha');
            $table->string('privado',1)->default(0); //0. Grupal 1. Privado
            $table->string('tipo',1)->default(1); //0. Endose 1.  Reserva
            $table->string('confirmado',1)->default(0); //0. Sin Confirmar  1. Confirmado 
            $table->string('observacion',250)->nullable();
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
        Schema::dropIfExists('reservas');
    }
};
