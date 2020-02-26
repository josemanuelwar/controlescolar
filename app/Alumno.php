<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    
	 protected $tabla = 'alumnos';

	 protected $fillabel=['Nombre','Fecha_de_nacimiento','Direccion','Telefono','Tutor_Responsable','Curso','Horario','Fech_de_inicio','Fecha_de_incripcion','N_semana_inicio','Semana_incripcion','Colegiatura','Total_incripcion','A_cuenta','Resta_incipcion','Nombre_de_Responsable'];

}
