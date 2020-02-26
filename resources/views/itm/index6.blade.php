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

		 <center><legend>Ticket de Compra</legend></center>
		<h2><label class="label label-default">Nombre del producto:</label></h2>
		@if(session()->has('mjs'))
			<div class="alert alert-danger alert-dismissible fade show" role="alert">{{session('mjs')}}</div>
		@endif
		@if( session()->has('ok'))
			<div class="alert alert-success" role="alert">
				{{session('ok')}}
			</div>
			@endif
		<form method="get" action="/ventas/">
			@csrf {{--justo aqui--}}
		<div class="field_wrapper">
		<div>
			<input class="form-control" type="text" name="field_name[]" value=""/>
			<h2><label class="label label-default">Cantidad</label> </h2>
		<input class="form-control" type="number" name="Precio[]" value="">
		<div class="input-group-btn">
			<a href="javascript:void(0);" class="add_button" title="Add field"><img src="/img/add.png" width="50px" height="50px"></a>
		</div>
		</div>
		</div>
		<h2><label>Responsable</label></h2>
		<input class="form-control" type="text" name="Nombre" value="{{ Auth::user()->name }}" readonly="readonly">
		<br>
		<center>
		<button class="btn btn-default" type="submit">
				        <i>Imprimir Ticket</i>
		</button>
		</center>
		
		</form>
@endsection
	<script src="/js/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="/js/ripples.min.js"></script>
	<script src="/js/material.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><h2><label class="label label-default">Nombre del producto:</label></h2><input class="form-control" type="text" name="field_name[]" value=""/><h2><label class="label label-default">Cantidad</label></h2><input class="form-control" type="number" name="Precio[]" value=""><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="/img/in.jpeg" width="50px" height="50px"></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>
</body>
</html>
