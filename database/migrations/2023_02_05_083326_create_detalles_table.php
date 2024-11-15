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
        Schema::create('detalles', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('reserva_id')-> unsigned();
            $table->foreign('reserva_id')->references('id')->on('reservas');
            $table->BigInteger('tour_id')-> unsigned();
            $table->foreign('tour_id')->references('id')->on('tours');
            $table->BigInteger('hotel_id')-> unsigned();
            $table->foreign('hotel_id')->references('id')->on('proveedors');
            $table->BigInteger('moneda_id')-> unsigned();
            $table->foreign('moneda_id')->references('id')->on('monedas');
            $table->decimal('ingreso',7,2);
            $table->date('fecha_viaje');
            $table->integer('cantidad');
            $table->decimal('precio',15,2);
            $table->text('observacion')->nullable();
            $table->string('pago',1)->default(0);
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
        Schema::dropIfExists('detalles');
    }
};
