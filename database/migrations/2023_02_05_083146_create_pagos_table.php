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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')-> unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->BigInteger('moneda_id')-> unsigned();
            $table->foreign('moneda_id')->references('id')->on('monedas');
            $table->BigInteger('medio_id')-> unsigned();
            $table->foreign('medio_id')->references('id')->on('medios');
            $table->BigInteger('reserva_id')-> unsigned();
            $table->foreign('reserva_id')->references('id')->on('reservas');
            $table->dateTime('fecha');
            $table->decimal('monto',15,2);
            $table->string('tarjeta',50)->nullable();
            $table->string('operacion',50)->nullable();
            $table->string('mensaje',250)->nullable();
            $table->string('confirmado',1)->default(0);
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
        Schema::dropIfExists('pagos');
    }
};
