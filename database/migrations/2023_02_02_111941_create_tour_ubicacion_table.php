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
        Schema::create('tour_ubicacion', function (Blueprint $table) {
            $table->BigInteger('tour_id')-> unsigned();
            $table->foreign('tour_id')->references('id')->on('tours');
            $table->BigInteger('ubicacion_id')-> unsigned();
            $table->foreign('ubicacion_id')->references('id')->on('ubicacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_ubicacion');
    }
};
