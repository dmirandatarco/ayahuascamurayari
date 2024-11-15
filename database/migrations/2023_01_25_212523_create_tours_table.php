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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',300)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('resumen',500)->nullable();
            $table->string('imagenprincipal',300)->nullable();
            $table->text('imagen_mapa')->nullable();
            $table->integer('tamaño_grupo')->nullable();
            $table->string('slug',315)->nullable();
            $table->integer('duracion')->nullable();
            $table->string('unidad',50)->nullable();
            $table->time('inicio')->nullable();
            $table->text('incluye')->nullable();
            $table->text('noincluye')->nullable();
            $table->text('recomendaciones')->nullable();
            $table->decimal('precio',7,2)->nullable();
            $table->decimal('precio_confidencial',7,2)->nullable();
            $table->BigInteger('categoria_id')-> unsigned();
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->BigInteger('entrada_id')-> unsigned()->nullable();
            $table->foreign('entrada_id')->references('id')->on('servicios');
            $table->string('voucher',300)->nullable();
            $table->string('web',1)->default(0);
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
        Schema::dropIfExists('tours');
    }
};
