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
   <form class="form-group" action="imprimirfec" method="get">
     <input type="text" name="fechasssss" style="visibility:hidden" value="{{$fecha}}">
        @csrf {{--justo aqui--}}
    <center><button class="btn btn-info">Imprimir corte del dia</button></center>
  </form>


<!-- tabla de inicio -->
<div class="container">
  <h2>Lista Pago de Colegiatura</h2>          
  <table class="table">
    <thead>
      <tr class='success'>
        <th>Matricula del Alumno</th>
        <th>Nombre del Alumno</th>
        <th>Responsable del cobro</th>
        <th>Fecha de pago</th>
        <th>Pago</th>
      </tr>
    </thead>
    <tbody id="tabla_resultados">
       @foreach ($tkm as $lista)
            <tr class="info">
              <td>{{$lista->Alumno_id}}</td>
              <td><?php $Nombre =DB::table('alumnos')->where('id',$lista->Alumno_id)->first();
              echo $Nombre->Nombre;
               ?></td>
              <td>{{$lista->Nombre_del_responsable}}</td>
              <td>{{$lista->Fecha_de_pago}}</td>
              <td>{{$lista->Pago}}</td>
            </tr>
      @endforeach 

      @foreach ($ins as $li)
            <tr class="info">
              <td>{{$li->id}}</td>
              <td>{{$li->Nombre}}</td>
              <td>{{$li->Nombre_de_Responsable}}</td>
              <td>{{$li->Fecha_de_incripcion}}</td>
              <td>{{$li->A_cuenta}}</td>
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