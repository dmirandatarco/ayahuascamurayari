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
        Schema::create('paquetes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 250);
            $table->text('titulo2');
            $table->text('descripcion');
            $table->text('recomendacion');
            $table->text('video');
            $table->text('mapa');
            $table->string('imgprincipal')->nullable();
            $table->integer('cantidad');
            $table->string('altura', 45);
            $table->text('incluye')->nullable();
            $table->text('noincluye')->nullable();
            $table->integer('dia');
            $table->string('tipo', 1);
            $table->BigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->BigInteger('moneda_id')->unsigned();
            $table->foreign('moneda_id')->references('id')->on('monedas');
            $table->decimal('total', 15, 2);
            $table->string('observacion', 250)->nullable();
            $table->string('estado', 1)->default(1);
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
        Schema::dropIfExists('paquetes');
    }
};
