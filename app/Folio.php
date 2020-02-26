<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folio extends Model
{
    //
    protected $tabla='folios';

    protected $fillabel=['id_col_incr','id_alumno','Fechadecobro','Numerosemana','Totalincripcion','Totalcolegitura'];
}
