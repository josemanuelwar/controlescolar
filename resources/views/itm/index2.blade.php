<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Sistema itm</title>
	
</head>
<body style="background-color:red">
	
@extends('layouts.app')

@section('content')
<div class="container col-md-8 col-md-offset-2">
 	<div class="well well bs-component">

 		<fieldset>

		 <center><legend>Registro de Productos</legend></center>
		 @if(session()->has('mjs'))
			<div class="alert alert-danger alert-dismissible fade show" role="alert">{{session('mjs')}}</div>
			@endif

			@if( session()->has('ok'))
			<div class="alert alert-success" role="alert">
				{{session('ok')}}
			</div>
			@endif
			
		<h5><label class="label label-default">Nombre del producto:</label></h5>
		<form class="form-group" action="/Registro_de_productos" method="post">
			@csrf {{--justo aqui--}}
		<div class="field_wrapper">
		<div>
			<input class="form-control" type="text" name="NombreP"/>
			<h5><label class="label label-default">Precio</label> </h5>
		<input class="form-control" type="number" name="Precio" value="">
		<h5><label>Cantidad</label></h5>
		<input class="form-control" type="number" name="Cantidad">
		</div>
		</div>
		<!--variables que no ven los usuarios-->
		<input class="form-control" type="text" name="Nombre" value="{{ Auth::user()->name }}" style="visibility:hidden" readonly="readonly">
		<br>
		<center>
		<button class="btn btn-default" type="submit">
				        <i>Agregar</i>
		</button>
		</center>
		
		</form>
@endsection
</fieldset>
</div>
</div>
</body>
</html>
<script src="/js/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="/js/ripples.min.js"></script>
	<script src="/js/material.min.js"></script>