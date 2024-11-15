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
        Schema::create('reserva_servicio', function (Blueprint $table) {
            $table->integer('cantidad');
            $table->BigInteger('reserva_id')-> unsigned();
            $table->foreign('reserva_id')->references('id')->on('reservas');
            $table->BigInteger('servicio_id')-> unsigned();
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->decimal('precio_venta',15,2);
            $table->decimal('precio_operacion',15,2);
            $table->string('descripcion',250)->nullable();
            $table->string('estado',1)->defaul(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserva_servicio');
    }
};
