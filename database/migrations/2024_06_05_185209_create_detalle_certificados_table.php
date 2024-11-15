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
        Schema::create('detalle_certificados', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('certificacio_id')->unsigned();
            $table->foreign('certificacio_id')->references('id')->on('certificacios');
            $table->string('url',250)->nullable();
            $table->string('urlabrir',250)->nullable();
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
        Schema::dropIfExists('detalle_certificados');
    }
};
