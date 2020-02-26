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
		
		<section class="content">

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
			      <button class="btn btn-success" id="buscar" type="submit">
				        <i>buscar</i>
				  </button>
		    </div>
		</div>
				 
		 <br>
      </fieldset>
      			<center><h1>Actualizar datos del Alumno</h1></center>
				
        <form class="form-group" action="/Actulizardatos/" method="get">
          @csrf {{--justo aqui--}}
        <input class="form-control" type="text" name="id" id="mat" style="visibility:hidden">	
				<label>Nombre </label>
				<input class="form-control" type="text" name="nombre"
				placeholder="Sanchez Vasquez Jose Juan" maxlength="60" id="nombre">
				<label>Fecha de Nacimiento</label>
				<input class="form-control" type="date" name="Edad" id="Fecha">
				<label>Tutor Responsable</label>
				<input class="form-control" type="text" name="Tutor" maxlength="60" id="Tutor">
				<label>Direccion</label>
				<input class="form-control" type="text" name="Direccion" maxlength="60" id="Direccion">
				<label>Telefono</label>
				<input class="form-control" type="tel" name="Telefono" pattern="[0-9]{10}" maxlength="10" id="Telefono">
				<label>Curso</label>
				<input class="form-control" type="text" name="Curso" id="Curso">
				<label>Horario y dia</label>
				<input class="form-control" type="text" name="Horario" id="Horario">
				<label>Fecha de Inicio</label>
				<input class="form-control" type="date" name="inicio" id="Inicio">
				<label>Semana de  inicio </label>
				<input class="form-control" type="number" name="Semana" id="Semana" min="1" pattern="^[0-9]">
				<label>Colegiatura</label>
				<input class="form-control" type="number" name="Mensualidad" id="Mensualidad" min="1" pattern="^[0-9]">
				<label>Incripcion</label>
				<input class="form-control" type="number" name="Deposito" id="Incripcion" min="1" pattern="^[0-9]">
				<label>Resta de Incripcion</label>
				<input class="form-control" type="number" name="Acuenta" id="Resta" min="0" pattern="^[0-9]">
				<input class="form-control" style="visibility:hidden" id="Responsable" type="text" value="{{ Auth::user()->name }}" readonly="readonly" name="Responsable">
				<br>
				<center>
				<button class="btn btn-primary" >Actulizar</button>
				</center>
        </form>
			</div>
		</div>
		</section>

@endsection
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="/js/ripples.min.js"></script>
	<script src="/js/material.min.js"></script>
</body>
</html>
<script type="text/javascript">
	$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    $(document).ready(function(){

        $('#buscar').click(function(){
        	var Matricula=document.getElementById('busacar').value;
           $.ajax({
               url: '/BuscarParaActualizar/'+Matricula,
               type: 'get',
               success: function(response){
                   if (response) {
                   	console.log("Obtuvimos  los datos de la base");

                   	console.log(response);
                   	$('#mat').val(response[0].id);
                   	$('#nombre').val(response[0].Nombre);
                   	$('#Fecha').val(response[0].Fecha_de_nacimiento);
                   	$('#Tutor').val(response[0].Tutor_Responsable);
                   	$('#Direccion').val(response[0].Direccion);
                   	$('#Telefono').val(response[0].Telefono);
                   	$('#Curso').val(response[0].Curso);
                   	$('#Horario').val(response[0].Horario);
                   	$('#Inicio').val(response[0].Fech_de_inicio);
                   	$('#Semana').val(response[0].N_semana_inicio);
                   	$('#Mensualidad').val(response[0].Colegiatura);
                   	$('#Incripcion').val(response[0].Total_incripcion);
                   	$('#Resta').val(response[0].Resta_incipcion)
                   }
               }
           }); 
        });
    });



/*$(document).ready(function(){

        $('#actulizar').click(function(){
          var Matricula=document.getElementById('mat').value;
        	var Nombre=document.getElementById('nombre').value;
        	var Fecha=document.getElementById('Fecha').value;
        	var Tutor=document.getElementById('Tutor').value;
        	var Direccion=document.getElementById('Direccion').value;
        	var Telefono=document.getElementById('Telefono').value;
        	var Curso=document.getElementById('Curso').value;
        	var Horario=document.getElementById('Horario').value;
        	var Inicio=document.getElementById('Inicio').value;
        	var Semana=document.getElementById('Semana').value;
        	var Mensualidad=document.getElementById('Mensualidad').value;
        	var Incripcion=document.getElementById('Incripcion').value;
        	var Resta=document.getElementById('Resta').value;
        	var Responsable=document.getElementById('Responsable').value;
        	
        	
        	var datos={};
          datos.Matricula=Matricula;	
        	datos.Nombre=Nombre;
        	datos.Fecha=Fecha;
        	datos.Tutor=Tutor;
        	datos.Direccion=Direccion;
        	datos.Telefono=Telefono;
        	datos.Curso=Curso;
        	datos.Horario=Horario;
        	datos.Inicio=Inicio;
        	datos.Semana=Semana;
        	datos.Mensualidad=Mensualidad;
        	datos.Incripcion=Incripcion;
        	datos.Resta=Resta;
        	datos.Responsable=Responsable;
        
        	var Actulizars = JSON.stringify(datos);
        	console.log(Actulizars);

           $.ajax({
			   
			   dataType:'JSON',           	
               url: '/Actulizardatos/'+Actulizars,
               type: 'get',
               success: function(response){
         			
         			if (response[0]==1) {
         				console.log(response[1]);
         			}else{
         				console.log(response[1]);
         			}

               }
           }); 
        });
    });*/

</script>