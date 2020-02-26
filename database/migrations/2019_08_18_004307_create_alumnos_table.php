<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Nombre');
            $table->string('Fecha_de_nacimiento');
            $table->string('Direccion');
            $table->string('Telefono');
            $table->string('Tutor_Responsable');
            $table->string('Curso');
            $table->string('Horario');
            $table->date('Fech_de_inicio');
            $table->date('Fecha_de_incripcion');
            $table->integer('N_semana_inicio');
            $table->integer('Semana_incripcion');
            $table->float('Colegiatura');            
            $table->float('Total_incripcion');
            $table->float('A_cuenta');
            $table->float('Resta_incipcion');
            $table->string('Nombre_de_Responsable');
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
        Schema::dropIfExists('alumnos');
    }
}
