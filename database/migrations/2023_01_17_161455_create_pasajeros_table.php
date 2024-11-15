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
        Schema::create('pasajeros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',255);
            $table->string('tipo_documento',15)->nullable();
            $table->string('num_documento',20)->nullable();
            $table->string('celular',30)->nullable();
            $table->string('email',150)->nullable();
            $table->BigInteger('pais_id')-> unsigned();
            $table->foreign('pais_id')->references('id')->on('pais');
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
        Schema::dropIfExists('pasajeros');
    }
};
