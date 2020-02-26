<?php

namespace App\Http\Controllers;
use App\controldeventas;
use App\RegistroColegiatura;
use App\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
include'C:\xampp\htdocs\sistema_de_cobranza/public/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class VentasController extends Controller
{


public function cortesemanadeproductosss(Request $request){

  $fecha=$request->input('fecha');
    $total=0;
    $resivo="";
    $incripcion="";
    $resivo= DB::table('controldeventas')->where('Numero_de_semana',$fecha)->get();
            foreach ($resivo as $value) {
               $total=$total+$value->Precio_total;
            }

 return view('itm.Productosdelistadelasemana')->with('tkm',$resivo)->with('tot',$total)->with('fecha',$fecha);
}


public function cortesemanal(Request $request){
$datos=$request->input('numerosemana');
$total=0;

$resivo= DB::table('registro_colegiaturas')->where('Semana_de_pago',$datos)->get();
 foreach ($resivo as $value) {
               $total=$total+$value->Pago;
            }
$incripcion=DB::table('alumnos')->where('Semana_incripcion',$datos)->get();
foreach ($incripcion as $key) {
                $total=$total+$key->A_cuenta;
            } 

return view('itm.colegi')->with('tkm',$resivo)->with('tot',$total)->with('ins',$incripcion);

}





public function improduct(Request $request){
    $datos=$request->input("fechasssss");
    $total=0;
    $resivo="";
    $incripcion="";
    $resivo= DB::table('controldeventas')->where('Fecha_compra',$datos)->get();

   
     /**
        **imprimiendo ticket de compras de productos
        **
        **/
        $nombre_impresora = "Post"; 

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
         date_default_timezone_set("America/Mexico_City");
         $printer->text(date("Y-m-d H:i:s") . "\n");

         $printer->text("Corte \n");

         $printer->text("-----------------------------" . "\n");
         $printer->setJustification(Printer::JUSTIFY_LEFT);
            foreach ($resivo as $value) {
               $printer->text("producto".$value->Numero_de_Procuctos." precio $".$value->Precio_total."\n"); 
               $total=$total+$value->Precio_total;
            }
            $printer->text("-----------------------------"."\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("TOTAL:\n");
            $printer->text("$".$total."\n");       
        
            $printer->feed(3);
            $printer->cut();
            $printer->close();
             return view('itm.productosdeldia')->with('tkm',$resivo)->with('tot',$total)->with('fecha',$datos);
}
/**
**buscando el corte por fecha de los productos
**
**/
public function buscandofecha(Request $request){
$fecha=$request->input('fecha');
$total=0;
    $resivo="";
    $incripcion="";
    $resivo= DB::table('controldeventas')->where('Fecha_compra',$fecha)->get();
            foreach ($resivo as $value) {
               $total=$total+$value->Precio_total;
            }

 return view('itm.productosdeldia')->with('tkm',$resivo)->with('tot',$total)->with('fecha',$fecha);
}


/**
**
**  imprimiendo la fecha de colegiatura 
**
**/

public function imprimeporfecha(Request $request){

$fecha=$request->input('fechasssss');

    $r=date("W");
    $total=0;
    $resivo="";
    $incripcion="";
    $total1=0;

    $resivo= DB::table('registro_colegiaturas')->where('Fecha_de_pago',$fecha)->get();

    $verif=DB::table('folios')->where("Fechadecobro",$fecha)->first();

   $fo=DB::table('folios')->where("Fechadecobro",$fecha)->get();
   
    $incripcion=DB::table('alumnos')->where('Fecha_de_incripcion',$fecha)->get();
            
     if( isset($verif)){     
  
    /**
        **imprimiendo ticket de compras de productos
        **
        **/
        $nombre_impresora = "Post"; 

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
         date_default_timezone_set("America/Mexico_City");
         $printer->text(date("Y-m-d H:i:s") . "\n");

         $printer->text("Corte \n");

         $printer->text("-----------------------------" . "\n");
         $printer->setJustification(Printer::JUSTIFY_LEFT);
             foreach ($fo as $value) {
                
                $printer->text("Folio ".$value->id."\n");
                $printer->text("Matricula  ".$value->id_alumno."\n");
                $printer->text("Colegiatura $".$value->Totalcolegitura."\n");
                if($value->Totalincripcion!=0){
                    $printer->text("Incripcion".$value->Totalincripcion."\n");
                    $total=$total+$value->Totalcolegitura+$value->Totalincripcion;
                }
               $total1=$total+$value->Totalcolegitura;

            }
            
            $printer->text("-----------------------------"."\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("TOTAL:\n");
            $printer->text("$".$total1."\n");       
        
            $printer->feed(3);
            $printer->cut();
            $printer->close();
        }else{

/**
        **imprimiendo ticket de compras de colegiatura
        **
        **/
        $nombre_impresora = "Post"; 

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
         date_default_timezone_set("America/Mexico_City");
         $printer->text(date("Y-m-d H:i:s") . "\n");

         $printer->text("Corte \n");

         $printer->text("-----------------------------" . "\n");
         $printer->setJustification(Printer::JUSTIFY_LEFT);     

    
    $resivo= DB::table('registro_colegiaturas')->where('Fecha_de_pago',$fecha)->get();
           
           foreach ($resivo as $value) {
                $printer->text("Matricula".$value->Alumno_id."\n");
                $printer->text("Colegiatura $".$value->Pago."\n");
               $total=$total+$value->Pago;
            }


            
            $incripcion=DB::table('alumnos')->where('Fecha_de_incripcion',$fecha)->get();
            foreach ($incripcion as $key) {
                $printer->text("Maricula".$key->id."\n");
                $printer->text("Inscripción $".$key->A_cuenta."\n");
                $total=$total+$key->A_cuenta;
            } 

$printer->text("-----------------------------"."\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("TOTAL:\n");
            $printer->text("$".$total."\n");       
        
            $printer->feed(3);
            $printer->cut();
            $printer->close();
}
    return view('itm.fechadeingresocolin')->with('tkm',$resivo)->with('tot',$total)->with('ins',$incripcion)->with('fecha',$fecha);


}

//muestra por fecha
public function mostracorteporfecha(Request $request){
    $fecha=$request->input('fecha');
    $r=date("W");
    $total=0;
    $resivo="";
    $incripcion="";
    $resivo= DB::table('registro_colegiaturas')->where('Fecha_de_pago',$fecha)->get();
            foreach ($resivo as $value) {
               $total=$total+$value->Pago;
            }


            
            $incripcion=DB::table('alumnos')->where('Fecha_de_incripcion',$fecha)->get();
            foreach ($incripcion as $key) {
                $total=$total+$key->A_cuenta;
            } 
            
return view('itm.fechadeingresocolin')->with('tkm',$resivo)->with('tot',$total)->with('ins',$incripcion)->with('fecha',$fecha);
}
//imprimimos el corte del dial
public function imprimircortedeldia(Request $request){
    $n=date("Y-m-d");
    $total=0;
    $resivo="";
    $incripcion="";
    $resivo= DB::table('controldeventas')->where('Fecha_compra',$n)->get();

    if ($resivo != null) {
     /**
        **imprimiendo ticket de compras de productos
        **
        **/
        $nombre_impresora = "Post"; 

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
         date_default_timezone_set("America/Mexico_City");
         $printer->text(date("Y-m-d H:i:s") . "\n");

         $printer->text("Corte \n");

         $printer->text("-----------------------------" . "\n");
         $printer->setJustification(Printer::JUSTIFY_LEFT);
            foreach ($resivo as $value) {
               $printer->text("producto".$value->Numero_de_Procuctos." precio $".$value->Precio_total."\n"); 
               $total=$total+$value->Precio_total;
            }
            $printer->text("-----------------------------"."\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("TOTAL:\n");
            $printer->text("$".$total."\n");       
        
            $printer->feed(3);
            $printer->cut();
            $printer->close();

    return view('itm.ingresoproducto')->with('tkm',$resivo)->with('tot',$total);
    }
}

/* mustra la venta del dia*/
public function Productosdia(Request $request){
    $n=date("Y-m-d");
    $total=0;
    $resivo="";
    $incripcion="";
    $resivo= DB::table('controldeventas')->where('Fecha_compra',$n)->get();
            foreach ($resivo as $value) {
               $total=$total+$value->Precio_total;
            }

    return view('itm.ingresoproducto')->with('tkm',$resivo)->with('tot',$total);

}
//Para Colegiaturas y incripcioon
public function IMprimirigresos(Request $request){

    $n=date("Y-m-d");
    $semana=date('W');
    $total=0;
    $resivo="";
    $incripcion="";
   
    $resivo= DB::table('registro_colegiaturas')->where('Fecha_de_pago',$n)->get();

   $fo=DB::table('folios')->where("Fechadecobro",date("Y-m-d"))->get();

    $incripcion=DB::table('alumnos')->where('Fecha_de_incripcion',$n)->get();
            
            
    /**
        **imprimiendo ticket de compras de productos
        **
        **/
        $nombre_impresora = "Post"; 

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
         date_default_timezone_set("America/Mexico_City");
         $printer->text(date("Y-m-d H:i:s") . "\n");

         $printer->text("Corte \n");

         $printer->text("-----------------------------" . "\n");
         $printer->setJustification(Printer::JUSTIFY_LEFT);
             foreach ($fo as $value) {
                
                $printer->text("Folio ".$value->id."\n");
                $printer->text("Matricula  ".$value->id_alumno."\n");
                $printer->text("Colegiatura $".$value->Totalcolegitura."\n");
                if($value->Totalincripcion!=0){
                    $printer->text("Incripcion".$value->Totalincripcion."\n");
                    $total=$total+$value->Totalcolegitura+$value->Totalincripcion;
                }
               $total=$total+$value->Totalcolegitura;

            }
            
            $printer->text("-----------------------------"."\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("TOTAL:\n");
            $printer->text("$".$total."\n");       
        
            $printer->feed(3);
            $printer->cut();
            $printer->close();

            return view('itm.index4')->with('tkm',$resivo)->with('tot',$total)->with('ins',$incripcion);   
}

/* muestra las opereaciones relizadas en el dia */
public function Ingresospordia(Request $request){
    $n=date("Y-m-d");
    $r=date("W");
    $total=0;
    $resivo="";
    $incripcion="";
 $resivo= DB::table('registro_colegiaturas')->where('Fecha_de_pago',$n)->get();
 
 
            foreach ($resivo as $value) {
               $total=$total+$value->Pago;

            }


            
    $incripcion=DB::table('alumnos')->where('Fecha_de_incripcion',$n)->get();
            foreach ($incripcion as $key) {
                $total=$total+$key->A_cuenta;
            } 



    return view('itm.index4')->with('tkm',$resivo)->with('tot',$total)->with('ins',$incripcion);   
}

/**
**
**Optenemos los datos de la base y lo mandamos a la vista 
**para mostrarlos en la tabla de lista de producto
**/
    public function ListadeProductos(Request $request){

     $lista=DB::table('productos')->get();

     return view('itm.index')->with('tkm',$lista);

    }




    /**
    **
    **Registro de Productos
    **
    **/
    public function RegistroDeProductos(Request $request){
        $res=1;
        if($request->input('NombreP')==null){
            $res=0;
        }
        if ($request->input('Precio')==null) {
            # code...
            $res=0;
        }
        if ($request->input('Cantidad')==null) {
            # code...
            $res=0;
        }
        if ($res==0) {
            # code...
            return back()->with('mjs','Falto uno o varios campos de llenado');
        }
        else{
                

            $Nombre=$request->input('NombreP');
            $Precio=$request->input('Precio');
            $Cantidad=$request->input('Cantidad');
        
        $lista=DB::table('productos')->where('Nombre',$Nombre)->first();
        
        if($lista === null){
            $producto = new Productos();
            $producto->Nombre=$Nombre;
            $producto->Cantidad=$Cantidad;
            $producto->Precio=$Precio;
            $producto->save();
            }else{
            $total=$lista->Cantidad+$Cantidad;
            
            $actul=DB::table('productos')
            ->where('Nombre', $Nombre)
            ->update(['Cantidad' => $total,"Precio"=>$Precio]);
            if($actul==1){
               return back()->with('ok','Se ha Actualizado el Producto'); 
            }
            else{
               return back()->with('ok','No Se ha Actualizado el Producto');  
            }
            }

            return back()->with('ok','Se ha registrado correctamente el producto ');
        }
    }


    /*
    **
    **mostramos los ingresos de las colegiaturas
    **
    */
    public function vercolegiaturasaxaj(Request $request, $datos){
        
        if ($request->isMethod('get')) {
          /**
        **imprimiendo ticket de compras de productos
        **
        **/
         $nombre_impresora = "Post"; 

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
         date_default_timezone_set("America/Mexico_City");
         $printer->text(date("Y-m-d H:i:s") . "\n");

         $printer->text("Corte \n");

         $printer->text("-----------------------------" . "\n");
         $printer->setJustification(Printer::JUSTIFY_LEFT);

            $total=0;
            $resivo="";
            $incripcion="";
            $resivo= DB::table('registro_colegiaturas')->where('Semana_de_pago',$datos)->get();
            foreach ($resivo as $value) {
              $printer->text("Colegiatura $".$value->Pago."\n");
               $total=$total+$value->Pago;
            }
            $incripcion=DB::table('alumnos')->where('Semana_incripcion',$datos)->get();
            foreach ($incripcion as $key) {
              $printer->text("Inscripción $".$key->A_cuenta."\n");
                $total=$total+$key->A_cuenta;
            }

            $printer->text("-----------------------------"."\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("TOTAL:\n");
            $printer->text("$".$total."\n");       
        
            $printer->feed(3);
            $printer->cut();
            $printer->close();

            return response()->json( [$resivo,$total,$incripcion]);        
        }
    }    

    /*
    **
    **mandamos a la vista los datos de ventas 
    *los  mostarmaos como un historial por via axaj
    */
    public function RegistrosAxaj(Request $request,$datos){
        $total=0;

        if ($request->isMethod('get')) {
          /**
        **imprimiendo ticket de compras de productos
        **
        **/
         $nombre_impresora = "Post"; 

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
         date_default_timezone_set("America/Mexico_City");
         $printer->text(date("Y-m-d H:i:s") . "\n");

         $printer->text("Corte \n");

         $printer->text("-----------------------------" . "\n");
         $printer->setJustification(Printer::JUSTIFY_LEFT);
            
            $resivo= DB::table('controldeventas')->where('Numero_de_semana',$datos)->get();
            foreach ($resivo as $value) {
              $printer->text($value->Numero_de_Procuctos."  ");
              $printer->text(" $".$value->Precio_total."\n");
               $total=$total+$value->Precio_total;
            }
            $printer->text("-----------------------------"."\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("TOTAL:\n");
            $printer->text("$".$total."\n");       
        
            $printer->feed(3);
            $printer->cut();
            $printer->close();

         return response()->json( [$resivo,$total]);


        }

    }


/*
**Guardamos los datos de cada venta y los ingresamos a la base de datos
**
*/
   public function IngresarVentas(Request $request){
    $Productos="";
    $Total="";
    $contador=0;
    $contador2;
    $aux="";
     if ($request->isMethod('get')) {
        $field_name=$request->input('field_name');
        $Numero_proc=$request->input('Precio');//numerao
        $logitud=count($field_name);
        $datos;
        for ($i=0; $i <$logitud ; $i++) { 
            # code...
            $datos=DB::table('productos')->where('Nombre',$field_name[$i])->first();
            if($datos==null){
                return back()->with('mjs','El producto no Está Registrado ');
                exit();
            }

            if($datos->Cantidad <= 0){

                return back()->with('mjs','Producto agotado verifica en la lista de productos');   
                exit();
            }else{
            $aux=$aux.$field_name[$i]." ".$Numero_proc[$i];
            $Cantidad=$datos->Cantidad-(float)$Numero_proc[$i];
            $Productos=$Productos.$field_name[$i]." ";
            $Total=$datos->Precio." ".$Total;
            $contador+=$datos->Precio*$Numero_proc[$i];
            $contador2[$i]=$datos->Precio;
            //actualizar tabla
            $actual=DB::table('productos')
            ->where('id',$datos->id)
            ->update(['Cantidad'=>$Cantidad]);

            }
        }

        $numeroSemana = date("W");
        
        $control= new controldeventas();
        $control->Nombre_Responsable=$request->input('Nombre');
        $control->Fecha_compra=date("Y-m-d");
        $control->Numero_de_semana=$numeroSemana;
        $control->Nombre_de_productos=$Productos;
        $control->Numero_de_Procuctos=$aux;
        $control->Precio_total=$contador;
        $control->save();

        $fol= DB::table('controldeventas')->where('Nombre_de_productos',$Productos)->latest()->first();
        
       /**
        **imprimiendo ticket de compras de productos
        **
        **/
         $nombre_impresora = "Post"; 

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
         $printer->text($request->input('Nombre')."\n");
         date_default_timezone_set("America/Mexico_City");
         $printer->text(date("Y-m-d H:i:s") . "\n");
         $printer->text("N° Folio \n");
         $printer->text($fol->id."\n");
         $printer->text("-----------------------------" . "\n");
         $printer->setJustification(Printer::JUSTIFY_LEFT);
         $printer->text("Lista de productos \n");
         for ($j=0; $j <$logitud ; $j++) { 
            # code...
          $printer->text($field_name[$j]."  ".$Numero_proc[$j]."  $".$contador2[$j] ."\n");
         }

          $printer->text("-----------------------------"."\n");
          $printer->setJustification(Printer::JUSTIFY_RIGHT);
          $printer->text("TOTAL:\n");
          $printer->text("$".$contador."\n");
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
        return back()->with('ok','Compra Realizada');
            

        


     }

   }
}