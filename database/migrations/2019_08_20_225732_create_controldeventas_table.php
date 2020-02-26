<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControldeventasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controldeventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Nombre_Responsable');
            $table->date('Fecha_compra');
            $table->integer('Numero_de_semana');
            $table->string('Nombre_de_productos',500);
            $table->string('Numero_de_Procuctos');
            $table->float('Precio_total');
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
        Schema::dropIfExists('controldeventas');
    }
}
