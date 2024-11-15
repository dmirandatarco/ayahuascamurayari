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
        Schema::create('servicio_tour', function (Blueprint $table) {
            $table->BigInteger('servicio_id')-> unsigned();
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->BigInteger('tour_id')-> unsigned();
            $table->foreign('tour_id')->references('id')->on('tours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicio_tour');
    }
};
