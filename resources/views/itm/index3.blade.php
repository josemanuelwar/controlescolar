	<!DOCTYPE html>
	<html>
	<head>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta charset="utf-8">
		<title>Sistema itm</title>
			
	</head>
	<body style="background-color:red">

@extends('layouts.app')

@section('content')
	<header>
		<center><h1>Registro de alumnos</h1></center>
	</header>
	
<section class="content">

<div class="container col-md-8 col-md-offset-2">
 	<div class="well well bs-component">
			@if(session()->has('mjs'))
			<div class="alert alert-danger alert-dismissible fade show" role="alert">{{session('mjs')}}</div>
			@endif

			@if( session()->has('ok'))
			<div class="alert alert-success" role="alert">
				{{session('ok')}}
			</div>
			@endif
			<form class="form-group" action="/RegistrosAlumnos" method="post">
				@csrf {{--justo aqui--}}
				<label>Nombre </label>
				<input class="form-control" type="text" name="nombre"
				placeholder="Sanchez Vasquez Jose Juan" maxlength="60" onkeyup="mayus(this);">
				<label>Fecha de Nacimiento</label>
				<input class="form-control" type="date" name="Edad">
				<label>Tutor Responsable</label>
				<input class="form-control" type="text" name="Tutor" maxlength="60">
				<label>Direccion</label>
				<input class="form-control" type="text" name="Direccion" maxlength="60">
				<label>Telefono</label>
				<input class="form-control" type="tel" name="Telefono" pattern="[0-9]{10}" maxlength="10">
				<label>Curso</label>
				<select class="form-control" name="curso">
					<option>......</option>
					<option>Curso de verano</option>
					<option>Autocad</option>
					<option>Esp.Diseño Grafico</option>
					<option>Esp.Asitente de Negocios con informatica</option>
					<option>Dip.Robotica</option>
					<option>Esp.Robotica</option>
					<option>Curso Infantil</option>
					<option>Curso de Matematicas</option>
					<option>Esp. Ingles</option>
					<option>Taekwondo</option>
					<OPTION>Curso Basico</OPTION>
					<option>Otro Curso</option>
				</select>
				<label>Horario y dia</label>
				<input class="form-control" type="text" name="Horario">
				<label>Fecha de Inicio</label>
				<input class="form-control" type="date" name="inicio">
				<label>Semana de  inicio </label>
				<input class="form-control" type="number" name="Semana" min="1" pattern="^[0-9]">
				<label>Colegiatura</label>
				<input class="form-control" type="number" name="Mensualidad" min="1" pattern="^[0-9]">
				<label>Inscripción</label>
				<input class="form-control" type="number" name="Deposito"min="1" pattern="^[0-9]">
				<input class="form-control" style="visibility:hidden" id="Responsable" type="text" value="{{ Auth::user()->name }}" readonly="readonly" name="Responsable">

				<br>
				<center>
				<button class="btn btn-primary">Registrar</button>
				</center>
			</form>
		
	@endsection
	</body>
	</html>
	<script src="/js/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="/js/ripples.min.js"></script>
	<script src="/js/material.min.js"></script>

	<script type="text/javascript">
		function mayus(e) {
    		e.value = e.value.toUpperCase();
		}
	</script>