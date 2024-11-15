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
        Schema::create('operars', function (Blueprint $table) {
            $table->id(); 
            $table->date('fecha');
            $table->integer('cantidad');
            $table->text('observacion')->nullable();
            $table->decimal('precio',7,2);//cambiar a monto lo migraste 
            $table->BigInteger('tour_id')-> unsigned();
            $table->foreign('tour_id')->references('id')->on('tours');
            $table->BigInteger('user_id')-> unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->decimal('monto_dar',7,2)->nullable();
            $table->string('tipo',1)->default(1);
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
        Schema::dropIfExists('operars');
    }
};
