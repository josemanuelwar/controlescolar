<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sistema itm</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body style="background-color:red">
  @extends('layouts.app')

@section('content')


   

    <br>
   <form class="form-group" action="improc" method="get">
        @csrf {{--justo aqui--}}
         <input type="text" name="fechasssss" style="visibility:hidden" value="{{$fecha}}">
    <center><button class="btn btn-info">Imprimir corte</button></center>
  </form>


<!-- tabla de inicio -->
<div class="container">
  <h2>Lista Pago de productos</h2>          
  <table class="table">
    <thead>
      <tr class='success'>
        <th>Nombre de producto</th>
        <th>Cantidad de producto</th>
        <th>Total</th>
        <th>Fecha de compra</th>
        <th>Nombre del responsable</th>
      </tr>
    </thead>
    <tbody id="tabla_resultados">
        @foreach ($tkm as $lista)
            <tr class="info">
              <td>{{$lista->Nombre_de_productos}}</td>
              <td>{{$lista->Numero_de_Procuctos}}</td>
              <td>{{$lista->Precio_total}}</td> 
              <td>{{$lista->Fecha_compra}}</td>
              <td>{{$lista->Nombre_Responsable}}</td>

            </tr>
      @endforeach
      
    </tbody>
    
  </table>
  <h3><label class="label label-default">total</label></h3>
  <input class="form-control" id="total" type="text" name="Matricula" readonly="readonly" placeholder="000" value="{{$tot}}">
   @endsection
  <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="/js/ripples.min.js"></script>
  <script src="/js/material.min.js"></script>
</body>
</html>