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
        Schema::create('totals', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('reserva_id')-> unsigned();
            $table->foreign('reserva_id')->references('id')->on('reservas');
            $table->BigInteger('moneda_id')-> unsigned();
            $table->foreign('moneda_id')->references('id')->on('monedas');
            $table->decimal('acuenta',15,2);
            $table->decimal('saldo',15,2);
            $table->decimal('total',15,2);
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
        Schema::dropIfExists('totals');
    }
};
