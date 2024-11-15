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
        Schema::create('detalle_liquidacions', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('liquidacion_id')-> unsigned();
            $table->foreign('liquidacion_id')->references('id')->on('liquidacions');
            $table->morphs('ejecutable');
            $table->integer('cantidad');
            $table->decimal('precio',15,2);
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
        Schema::dropIfExists('detalle_liquidacions');
    }
};
