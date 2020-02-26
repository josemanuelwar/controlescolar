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
<!-- tabla de inicio -->
<div class="container">
  <center><h2>Lista de productos</h2></center>          
  <table class="table">
    <thead>
      <tr class='success'>
        <th>Nombre de producto</th>
        <th>Cantidad de producto</th>
        <th>Precio</th>
      </tr>
    </thead>
    <tbody >
      @foreach ($tkm as $lista)
            <tr class="info">
              <td>{{$lista->Nombre}}</td>
              <td>{{$lista->Cantidad}}</td>
              <td>{{$lista->Precio}}</td>
            </tr>
      @endforeach 
    </tbody>
  </table>
  @endsection
  <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="/js/ripples.min.js"></script>
  <script src="/js/material.min.js"></script>
</body>
</html>
