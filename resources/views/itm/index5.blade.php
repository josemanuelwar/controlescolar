<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sistema itm</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body style="background-color:red">
  <!-- menu-->
  @extends('layouts.app')

@section('content')


<div class="container col-md-8 col-md-offset-2">
 	<div class="well well bs-component">
       <fieldset>
           <legend>Instituto Técnico de México</legend>

           <div class="input-group">
           	<label>Matricula</label>
           </div>
            <div class="input-group">

				    <input type="text" class="form-control" id="busacar" placeholder="Search">
			<div class="input-group-btn">
			      <button class="btn btn-success" id="enviar" type="submit">
				        <i>buscar</i>
				  </button>
		    </div>
		</div>
				 
		 <br>
      </fieldset>
	<fieldset>
		<legend>Datos del alumno</legend>
    <h5><label class="label label-default">Matricula:</label> </h5>
		
    <input class="form-control" id="Matricula" type="text" name="Matricula" readonly="readonly" placeholder="000">
	
		<h5><label class="label label-default">Nombre del Alumno:</label></h5>
		<input class="form-control" id="Nombre" type="text" name="Nombre" readonly="readonly" placeholder="juan">
		<h5><label class="label label-default">Cuota semanal	</label></h5>
		<input class="form-control" id="pago" readonly="readonly" type="text" name="pago">
    <hr style="border:10px; color: black;">
    <h4>Adeudos</h4>
    <h5><label>Inscripción</label></h5>
    <input class="form-control" type="text" name="Incripcion" id="Incripcion" readonly="readonly">
    <h5><label>Colegiatura</label></h5>
    <input class="form-control" type="text" name="Coleguiatura" id="Coleguiatura" readonly="readonly">

    <hr style="border:10px; color: black;">
    <h5><label id="label3">Pagos</label></h5>
     <h5><label id="label2">Colegiatura A cuenta</label></h5">
   
    <input class="form-control" type="number" name="cuenta" id="cuenta">
    
    <h5><label id="label1">Inscripción A cuenta</label></h5>
    <input class="form-control" type="number" name="A_cuenta" id="A_cuenta">

    <!-- Adelantar  semana -->
    <label id="AD" style="display: none;">Semanas a pagar</label>
    <input class="form-control" type="number" name="lant" id="lant" style="display: none;">
    <button id="Adelantar" onclick="Adelantar();" class="btn btn-success" style="display: none;" >Pagar </button>
    <!--lo que el usuario no ve son unas variables-->
		<input class="form-control" style="visibility:hidden"  id="Responsable" type="text" value="{{ Auth::user()->name }}" readonly="readonly">

    <input class="form-control" style="visibility:hidden" type="text" name="id_A" id="identificasion" >
    <center>
    <button class="btn btn-primary" id="Guardardatos">Guardar</button>
    </center>
    <br> 
    </fieldset>
</div>
</div>
@endsection
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="/js/ripples.min.js"></script>
	<script src="/js/material.min.js"></script>
<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    $(document).ready(function(){
        $('#btnImprimir').click(function(){
           $.ajax({
               url: '/imprimir',
               type: 'POST',
               success: function(response){
                   if(response==1){
                       alert('Imprimiendo....');
                   }else{
                       alert('Error');
                   }
               }
           }); 
        });
    });
///paspasaps
    $(document).ready(function(){
        $('#enviar').click(function(){
           var Matricula=document.getElementById('busacar').value;
           $.ajax({

           		datatype: 'JSON',
               url: '/busqueda/'+Matricula,
               type: 'get',
               success: function(response){
                   if(response){
                     console.log('obtuvimos los datos');
                     $('#Matricula').val(response[0].id);
                     $('#Nombre').val(response[0].Nombre);
                     $('#pago').val(response[0].Colegiatura);
                      
                      console.log(response);

                     if(response[0].Resta_incipcion == 0){                   	
                      $('#Incripcion').val('Pagado');
                      //desaparesen
                      document.getElementById('A_cuenta').style.display = 'none';
                      document.getElementById('label1').style.display='none';
                      document.getElementById('label3').style.display='none';
                      document.getElementById('Guardardatos').style.display='none';
                      document.getElementById('Incripcion').style.backgroundColor = '#E5E8E8';
                     

                      }else{
                        //se muestren
                        $('#Incripcion').val(response[0].Resta_incipcion);
                        document.getElementById('A_cuenta').style.display = 'block';
                        document.getElementById('label1').style.display='block';
                        document.getElementById('label3').style.display='block';
                        document.getElementById('Guardardatos').style.display='block';
                        document.getElementById('Incripcion').style.backgroundColor = 'yellow';


                      }

                      if(response[1] == 0){
                        $('#Coleguiatura').val(response[0].Colegiatura);
                        document.getElementById('cuenta').style.display = 'block';
                        document.getElementById('label2').style.display='block';
                        document.getElementById('label3').style.display='block';
                        document.getElementById('Guardardatos').style.display='block';
                         document.getElementById('Coleguiatura').style.backgroundColor = 'yellow';
                        document.getElementById('AD').style.display='none';
                        document.getElementById('lant').style.display='none';
                        document.getElementById('Adelantar').style.display='none';
                        document.getElementById('cuenta').value='';


                      }else{
                          
                          $('#Coleguiatura').val('Semana Pagada Nº '+response[1].Semana_de_pago);
                          document.getElementById('cuenta').style.display = 'none';
                          document.getElementById('label2').style.display='none';
                          document.getElementById('label3').style.display='none';
                         // document.getElementById('Guardardatos').style.display='none';
                         document.getElementById("cuenta").value="";
                         document.getElementById('Coleguiatura').style.backgroundColor = '#E5E8E8';

                          document.getElementById('AD').style.display='block';
                          document.getElementById('lant').style.display='block';
                          document.getElementById('Adelantar').style.display='block';

                        
                      }
                   }else{
                       console.log('Error en la busqueda');
                   }
               }
           }); 
        });
    });
  /***
***
  guardamos los datos
***
  ***/
$(document).ready(function(){
        $('#Guardardatos').click(function(){
           var matricula=document.getElementById('Matricula').value;
           var id=document.getElementById('identificasion').value;
           var Responsable=document.getElementById('Responsable').value;
           var pago=document.getElementById('cuenta').value;//icripcion

           var Incripcion=document.getElementById('A_cuenta').value;//Colegiatura
           var total=document.getElementById('Incripcion').value;//sub total
           var datos={};
           datos.id=id;
           datos.matricula=matricula;
           datos.Responsable=Responsable;
           datos.Coleguiatura=pago;
           datos.Incripcion=Incripcion;
           datos.Total=total;
           var jsonCompleto = JSON.stringify(datos);            
           console.log(jsonCompleto);
           $.ajax({

              datatype: 'JSON',
               url: '/guardar/'+jsonCompleto,
               type: 'get',
               success: function(response){
                   if(response[0]!= null){
                     console.log(response[0]);
                     
                   }else{
                       console.log('Error en la Reguistrar los datos en la base de datas');
                   }
               }
           }); 
        });
    });

function Adelantar(){

  var Adelantar= document.getElementById('lant').value;
  var matricula=document.getElementById('Matricula').value;
  var Responsable=document.getElementById('Responsable').value;
  if(Adelantar != 0){
  var datas={};
  datas.Adelantar=Adelantar;
  datas.matricula=matricula;
  datas.Responsable=Responsable;
  var json = JSON.stringify(datas);            
           console.log(json);
  $.ajax({

            datatype: 'JSON',
            url: '/Adelantar/'+json,
            type: 'get',
              success: function(response){

                if (response[0] != null) {
                  console.log(response[0]);
                  document.getElementById('lant').value=0;
                }
              }
           }); 
}
}
</script>
</body>
</html>
