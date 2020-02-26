<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroColegiatura extends Model
{
   protected $tabla="registro_colegiaturas";
   protected $fillable=['Fecha_de_pago','Semana_de_pago','Nombre_del_responsable','Alumno_id','Pago'];
}
