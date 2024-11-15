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
        Schema::create('operar_proveedor', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('operar_id')-> unsigned();
            $table->foreign('operar_id')->references('id')->on('operars');
            $table->BigInteger('proveedor_id')-> unsigned();
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
            $table->BigInteger('servicio_id')-> unsigned();
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->decimal('monto',7,2);
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
        Schema::dropIfExists('operar_proveedor');
    }
};
