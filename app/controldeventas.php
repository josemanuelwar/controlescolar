<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class controldeventas extends Model
{
    //
    protected $tabla="controldeventas";
    protected $fillable=['Nombre_Responsable','Fecha_compra','Numero_de_semana','Nombre_de_productos','Numero_de_Procuctos','Precio_total'];
}
