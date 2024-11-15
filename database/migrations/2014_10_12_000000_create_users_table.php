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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',50)->nullable();
            $table->string('apellido',150)->nullable();
            $table->string('tipo_documento',20)->nullable();
            $table->string('num_documento',20)->nullable();
            $table->string('celular',20)->nullable();
            $table->string('email',150)->nullable();
            $table->date('cumpleaños')->nullable();
            $table->string('usuario',191)->unique();
            $table->string('password',191)->nullable();            
            $table->string('estado',1)->default(1);
            $table->string('imagen')->nullable();
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
        Schema::dropIfExists('users');
    }
};
