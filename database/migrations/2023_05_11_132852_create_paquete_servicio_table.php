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
        Schema::create('paquete_servicio', function (Blueprint $table) {
            $table->integer('cantidad');
            $table->BigInteger('paquete_id')-> unsigned();
            $table->foreign('paquete_id')->references('id')->on('paquetes');
            $table->BigInteger('servicio_id')-> unsigned();
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->string('estado',1)->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paquete_servicio');
    }
};
