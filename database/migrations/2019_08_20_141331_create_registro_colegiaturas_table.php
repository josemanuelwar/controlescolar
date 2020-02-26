<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistroColegiaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_colegiaturas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('Fecha_de_pago');
            $table->integer('Semana_de_pago');
            $table->string('Nombre_del_responsable');
            $table->integer('Pago');
            $table->unsignedBigInteger('Alumno_id');
            $table->foreign('Alumno_id')->references('id')->on('alumnos');
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
        Schema::dropIfExists('registro_colegiaturas');
    }
}
