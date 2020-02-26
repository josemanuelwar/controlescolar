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
    <div class="input-group">
            <label>Numero de semana</label>
           </div>
            <div class="input-group">

            <input type="text" class="form-control" id="busacar" placeholder="Search">
      <div class="input-group-btn">
            <button class="btn btn-default" id="enviar" type="submit">
                <i>Imprimir corte semanal </i>
          </button>
        </div>
    </div>



     <form class="form-group" action="buscarproductospordia" method="get">
      @csrf {{--justo aqui--}}
      <div class="input-group">
                  <label>Fecha</label>
     <div class="input-group">

            <input type="date" class="form-control" name="fecha" placeholder="Search">
      <div class="input-group-btn">
            <button class="btn btn-default"  type="submit">
                <i>buscar</i>
          </button>
        </div>
      </div>
    </div>
    </form>
    <br>
    
    <form class="form-group" action="Productos" method="post">
      @csrf {{--justo aqui--}}
      <div class="input-group">
     <div class="input-group">
      <div class="input-group-btn">
      <center>
      <button class="btn btn-info" >Ingreso del dia</button>
      </center>
        </div>
      </div>
    </div>

    </form>


     <form class="form-group" action="listadeproductossemanales" method="get">
      @csrf {{--justo aqui--}}
      <div class="input-group">
                  <label>Buscar el Corte del semana</label>
     <div class="input-group">

            <input type="number" class="form-control" name="fecha" placeholder="Search">
      <div class="input-group-btn">
            <button class="btn btn-default"  type="submit">
                <i>buscar</i>
          </button>
        </div>
      </div>
    </form>
<!-- tabla de inicio -->
<div class="container">
  <h2>Lista de productos vendidos</h2>          
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
      
    </tbody>
  </table>
  <h2><label>Total</label></h2>
  <input class="form-control" id="total" type="text" name="Matricula" readonly="readonly" placeholder="000">
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
        $('#enviar').click(function(){
           var semana=document.getElementById('busacar').value;
           $.ajax({

              datatype: 'JSON',
               url: '/veregistro/'+semana,
               type: 'get',
               success: function(response){
                   if(response){
                     console.log('obtuvimos los datos');
                     console.log(response[1]);
                     var totalganado;
                     
                   }else{
                       console.log('Error en la busqueda');
                   }
               }
           }); 
        });
    });
</script>