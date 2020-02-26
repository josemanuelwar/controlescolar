<?php

namespace App\Http\Controllers;
use App\User;
use App\Alumno;
use App\Folio;
use App\RegistroColegiatura;
use Illuminate\Http\Request;
use Illuminate\http\Responses;
use Illuminate\Support\Facades\DB;
include'C:\xampp\htdocs\sistema_de_cobranza/public/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


class AlumnosRegistroController extends Controller
{

/**
**
**funcion para adelantar las semanas de colegiatura
**
**/
public function AdelantarSemanaAjax(Request $request, $id){

   if ($request->isMethod('get')) {
   $NºSemana;
   $folio;
   $fecha=date("Y-m-d");
   $dato=json_decode($id);
   $id_con="";
   $resivo= DB::table('alumnos')->where('id',$dato->matricula)->first();
   if ($resivo == null) {
      $ok="No se Encuentra en la base de datos";
   }else{   
            $semana= DB::table('registro_colegiaturas')->where('Alumno_id',$dato->matricula)->latest()->first();
            if($semana == null){
               $ok="No se Encuentra en la base de datos de Colegiatura";
            }else{
               $num=(integer)$dato->Adelantar;
               for ($i=0; $i <$num; $i++) {
$semana= DB::table('registro_colegiaturas')->where('Alumno_id',$dato->matricula)->latest()->first();
$NºSemana[$i]=$semana->Semana_de_pago+1;
   if($semana->Semana_de_pago > 52){
$id = DB::table('registro_colegiaturas')->insert(['Fecha_de_pago' =>$fecha, 'Semana_de_pago' =>1, 'Nombre_del_responsable' =>$dato->Responsable,'Alumno_id'=> $dato->matricula,'Pago'=>$resivo->Colegiatura,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);
$semana= DB::table('registro_colegiaturas')->where('Alumno_id',$dato->matricula)->latest()->first();
$id_con=$semana->id." ".$id_con;
sleep(1);

   }else{
$id = DB::table('registro_colegiaturas')->insert(['Fecha_de_pago' =>$fecha, 'Semana_de_pago' => $semana->Semana_de_pago+1, 'Nombre_del_responsable' =>$dato->Responsable,'Alumno_id'=> $dato->matricula,'Pago'=>$resivo->Colegiatura,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);
$semana= DB::table('registro_colegiaturas')->where('Alumno_id',$dato->matricula)->latest()->first();
$id_con=$semana->id." ".$id_con;
sleep(1);
   }
                  
                  }
            }
         }
if($id){
  $total1=($num*(integer)$resivo->Colegiatura);

$ok="Se ha guardado correcta mente los datos";

        $folio=new Folio();
        $folio->id_col_incr=$id_con;
        $folio->id_alumno=$dato->matricula;
        $folio->Fechadecobro=$fecha;
        $folio->Totalcolegitura=$total1;
        $folio->Totalincripcion=0;
        $folio->Numerosemana=date("W");


        $folio->save();

        $fol= DB::table('folios')->latest()->first();
        /**
        **imprimiendo ticket de compras de productos
        **
        **/
         $nombre_impresora = "imprciontickes"; 

        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
            /*imagen del la institucion*/
            try{
                  $logo = EscposImage::load("img/logo1.png", false);
                   $printer->bitImage($logo);
            }catch(Exception $e){/*No hacemos nada si hay error*/}

         $printer->setJustification(Printer::JUSTIFY_CENTER);
         $printer->text("\n"."Instituto Tecnico de Mexico" . "\n");
         $printer->text("Direccion:" . "\n");
         $printer->text("Boulevard carlos camacho espíritu" . "\n");
         $printer->text("Tel: 2222800926" . "\n");
         $printer->text("Responsable del Cobro \n");
         $printer->text($dato->Responsable."\n");
         date_default_timezone_set("America/Mexico_City");
         $printer->text(date("Y-m-d H:i:s") . "\n");
         $printer->text("N° Folio \n");
         $printer->text($fol->id);
         
         $printer->text("\n");
         $printer->text("-----------------------------" . "\n");
         $printer->setJustification(Printer::JUSTIFY_LEFT);
         $printer->text("Matricula \n");
         $printer->text($dato->matricula."\n");
         $printer->text("Nombre de Alumno \n");
         $printer->text($resivo->Nombre."\n");
         //$printer->text($fol->id."\n");
         $printer->text("-----------------------------" . "\n");
         $printer->setJustification(Printer::JUSTIFY_LEFT);
         
         for ($j=0; $j <$num; $j++) { 
            # code...

          $printer->text("Numero de semana ".$NºSemana[$j]. " $".$resivo->Colegiatura ."\n");
         }

         $printer->text("-----------------------------"."\n");
          $printer->setJustification(Printer::JUSTIFY_RIGHT);
          $printer->text("TOTAL:\n");
          $printer->text("$".$resivo->Colegiatura*$num."\n");
          $printer->text("\n \n");
          
          $printer->setJustification(Printer::JUSTIFY_CENTER);
          $printer->text("-----------------------------"."\n");
          $printer->text("Muchas gracias\n");
          $printer->text("Siempre y de forma inmediata le deben entregar su comprobante de pago \n");
          $printer->text("y debe coincidir con el concepto de pago realizado por usted \n");
          $printer->text("Si no se lo entregan o el concepto de pago es distinto, favor de reportarlo al 2222 800 926 \n");
          $printer->text("y se le bonificara Gratis una colegiatura");
          $printer->feed(3);
          $printer->cut();
          $printer->close();






   }else{
   $ok="No Se han guardado los datos";
   }
}
return response()->json([$ok]);
}

/**
**
** Octenemos los datos del alumno 
** por la matricula 
**/
public function BuscarAlunosActualizarAjax(Request $request,$datos){

         if ($request->isMethod('get')) {
           
           $Actalumno= DB::table('alumnos')->where('id',$datos)->first();

           return response()->json([$Actalumno]); 

         }

}
/**
**
**Guardamos los datos una vez modificados
**
**/
public function ActualizarAlumnosajax(Request $request){

if ($request->isMethod('get')) {
       
       $Mtricula=$request->input('id');
       $nombre=$request->input('nombre');
       $Edad=$request->input('Edad');
       $Tutor=$request->input('Tutor');
       $Direccion=$request->input('Direccion');
       $Telefono=$request->input('Telefono');
       $Curso=$request->input('Curso');
       $Horario=$request->input('Horario');
       $inicio=$request->input('inicio');
       $Semana=$request->input('Semana');
       $Mensualidad=$request->input('Mensualidad');
       $Deposito=$request->input('Deposito');
       $Acuenta=$request->input('Acuenta');
       $Responsable=$request->input('Responsable');
       $Incripcion=$request->input('Deposito');

       
$actual=DB::table('alumnos')->where('id',$Mtricula)
->update(['Nombre'=>$nombre,
   'Fecha_de_nacimiento'=>$Edad,
   'Direccion'=>$Direccion,
   'Telefono'=>$Telefono,
   'Tutor_Responsable'=>$Tutor,
   'Curso'=>$Curso,
   'Horario'=>$Horario,
   'Fech_de_inicio'=>$inicio,
   'N_semana_inicio'=>$Semana,
   'Colegiatura'=>$Mensualidad,
   'Total_incripcion'=>$Incripcion,
   'Resta_incipcion'=>$Acuenta,
   'Nombre_de_Responsable'=>$Responsable
   ]);
         if ($actual == 0) {
            $msl='Ocurrio un error';
            $ban=0;
         }else{
            $msl='Se han Modificado correctamente los datos';
            $ban=1;
         }
     echo $msl;  

     return back();      
         
   }

}


/*guardamos los datos*/
public function Guardardatos(Request $request,$datos){
              
         $nombre=json_decode($datos);
         $numerodesemana=date('W');
         $fecha=date("Y-m-d");
         $suma=0;
         $id_con="";
         $total=0;
         $fechass=date("Y-m-d");

         $fo=DB::table('folios')->latest()->first();
         if($fo==null){
          $aux=1;
         }else{
         $aux=$fo->id+1;
         }
         $resivo= DB::table('alumnos')->where('id',$nombre->matricula)->first();
         
         if($resivo !=null )   
/**
**IMprimiendo tickts de coleguiatura
**/
      $nombre_impresora = "imprciontickes"; 

        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
            /*imagen del la institucion*/
            try{
                  $logo = EscposImage::load("img/logo1.png", false);
                   $printer->bitImage($logo);
            }catch(Exception $e){/*No hacemos nada si hay error*/}

         $printer->setJustification(Printer::JUSTIFY_CENTER);
         $printer->text("\n"."Instituto Tecnico de Mexico" . "\n");
         $printer->text("Direccion:" . "\n");
         $printer->text("Boulevard carlos camacho espíritu" . "\n");
         $printer->text("Tel: 2222800926" . "\n");
         $printer->text("Responsable del Cobro \n");
         $printer->text($nombre->Responsable."\n");
         date_default_timezone_set("America/Mexico_City");
         $printer->text(date("Y-m-d H:i:s") . "\n");

         if ($nombre->Coleguiatura != null){
        
         $colegiatura= new RegistroColegiatura();
         $colegiatura->Fecha_de_pago=$fecha;
         $colegiatura->Semana_de_pago=$resivo->N_semana_inicio;
         $colegiatura->Nombre_del_responsable=$nombre->Responsable;
         $colegiatura->Alumno_id=$nombre->matricula;
         $colegiatura->Pago=$nombre->Coleguiatura;
         $colegiatura->save();

         $ok="se ha Guardado correctamente en la base de dato";

         $semana= DB::table('registro_colegiaturas')->where('Alumno_id',$nombre->matricula)->first();
          $id_con=$semana->id." ".$id_con;

          

            $printer->text("N° Folio \n");
            $printer->text($aux."\n");
        
            $printer->text("-----------------------------" . "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Matricula \n");
            $printer->text($nombre->matricula."\n");
            $printer->text("Nombre de Alumno \n");
            $printer->text($resivo->Nombre."\n");
            $printer->text("Colegiatura  \n");
            $printer->text("Semanas ".$semana->Semana_de_pago."\n" );
            $printer->text("   $".$nombre->Coleguiatura."\n");   
            $suma=$suma+$nombre->Coleguiatura;
            }else{
            
           
            $printer->text("N° Folio \n");
            $printer->text($aux."\n");
            $printer->text("-----------------------------" . "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Matricula \n");
            $printer->text($nombre->matricula."\n");
            $printer->text("Nombre de Alumno \n");
            $printer->text($resivo->Nombre."\n");
          
          }
            
            if ($nombre->Incripcion != null) {
            $suma=$suma+$nombre->Incripcion;
            $total=(float)$nombre->Total-(float)$nombre->Incripcion;
            if ($total < 0) {
              exit();
            }else{

         //actualizamos la tabla de alumnos
            $actual=DB::table('alumnos')
            ->where('id', $nombre->matricula)
            ->update(['Resta_incipcion' =>$total,'A_cuenta'=>$nombre->Incripcion,'Semana_incripcion'=>$numerodesemana,'Fecha_de_incripcion'=>$fechass,'Nombre_de_Responsable'=>$nombre->Responsable]);
            
            $id_con=$nombre->matricula." ".$id_con;
             
            $ok="se ha Guardado Correctamente en la base de datos";
            /////
            $printer->text("Inscripción \n");
            $printer->text("  $".$nombre->Incripcion."\n");
          }

         }
         $printer->text("-----------------------------"."\n");
         $printer->setJustification(Printer::JUSTIFY_RIGHT);
         $printer->text("TOTAL:\n");
         $printer->text("$".$suma."\n");

         $printer->text("\n \n");
         $printer->setJustification(Printer::JUSTIFY_CENTER);
         $printer->text("-----------------------------"."\n");
         $printer->text("Muchas gracias\n");
         $printer->text("Siempre y de forma inmediata le deben entregar su comprobante de pago \n");
         $printer->text("y debe coincidir con el concepto de pago realizado por usted \n");
         $printer->text("Si no se lo entregan o el concepto de pago es distinto, favor de reportarlo al 2222 800 926 \n");
         $printer->text("y se le bonificara Gratis una colegiatura");
         $printer->feed(3);
         $printer->cut();
         $printer->close();
         $suma=0;

         $folio = new Folio();
         $folio->id_col_incr=$id_con;
         $folio->id_alumno=$nombre->matricula;
         $folio->Fechadecobro=$fecha;
         $folio->Numerosemana=date("W");
         $folio->Totalcolegitura=(integer)$nombre->Coleguiatura;
         $folio->Totalincripcion=(integer)$nombre->Incripcion;
         $folio->save();
         return response()->json([$ok]);
   
}


/***
***
**funcion para la busqueda del alumno
***
***/
public function busqueda (Request $request,$id){

      if ($request->isMethod('get')) {
         # code...
         $n_semana=date("W");
         $resivo= DB::table('alumnos')->where('id',$id)->first();

         $semana= DB::table('registro_colegiaturas')->where('Alumno_id',$id)->latest()->first();
         if ($semana == null) {
            $semana=0;
         }
         
         return response()->json([ $resivo, $semana, $n_semana ]);

      }
     

}
/**
*
*funcion donde requperamos los datos para el resibo imprimir
*
**/
   public function Incripcion($id){
   
   $resivo= DB::table('alumnos')->where('id',$id)->first();
   return view('itm.index4')->with('tkm',$resivo);
   
   }
/** 
*
* funcion en donde elvaluamos los campos
** y almasenamos en la base de datos
****/
   public function RegistroAlumnos(Request $request){
 
 		$ban=0;
   		if ($request->input('nombre')==null) {
   			$ban=1;
   		}
   		if ($request->input('Edad')==null) {
   			$ban=1;
   		}
   		if ($request->input('Tutor')==null) {
   			$ban=1;
   		}
   		if ($request->input('Direccion')==null) {
   			# code...
   			$ban=1;
   		}
   		
         if ($request->input('inicio')==null) {
            $ban=1;
         }
   		if ($request->input('Mensualidad')==null) {
   			$ban=1;
   		}
   		if ($request->input('curso')== null) {
   			$ban=1;
   		}
   		if ($request->input('Telefono')==null) {
   			$ban=1;
   		}
   		if ($request->input('Horario')==null) {
   			# code...
   			$ban=1;
   		}
   		if ($request->input('Semana')==null) {
   			$ban=1;
   		}
   		if ($request->input('Deposito')==null) {
   			$ban=1;
   		}
   		
   		
   		if ($ban==1) {
   			# code...
   			return back()->with('mjs','Falto uno o varios campos de llenado');
   		}else{
            $saldo=$request->input('Deposito');//Incripcion
            $colg=$request->input('Mensualidad');//colegiatura
            $Total_parcial=$saldo-0;//Restante

            	$alumno = new Alumno();

            	$alumno->Nombre=$request->input('nombre');
            	$alumno->Fecha_de_nacimiento=$request->input('Edad');
            	$alumno->Direccion=$request->input('Direccion');
            	$alumno->Tutor_Responsable=$request->input('Tutor');
            	$alumno->Fecha_de_incripcion=date("Y-m-d");
               $alumno->Fech_de_inicio=$request->input('inicio');
            	$alumno->Colegiatura=$request->input('Mensualidad');
            	$alumno->Curso=$request->input('curso');
            	$alumno->Telefono=$request->input('Telefono');
            	$alumno->N_semana_inicio=$request->input('Semana');
            	$alumno->Total_incripcion=$request->input('Deposito');
               $alumno->Semana_incripcion=date("W");
               $alumno->Horario=$request->input('Horario');
               $alumno->A_cuenta=0;
               $alumno->Resta_incipcion=$Total_parcial;
               $alumno->Nombre_de_Responsable=$request->input('Responsable');
            	$alumno->save();

               $nombre=$request->input('nombre');
               $curso=$request->input('curso');
               
               $resivo= DB::table('alumnos')->where('Nombre',$nombre)->where('Curso',$curso)->first();
            
               return back()->with('ok','Se han Guardado Correctamente los datos',$resivo->id);  			

   		}
   	}
}
