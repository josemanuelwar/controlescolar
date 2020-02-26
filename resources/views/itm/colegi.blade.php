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

    <div class="input-group">
            <label>Numero de semana</label>
           </div>
            <div class="input-group">

            <input type="text" class="form-control" id="busacar" placeholder="Search">
      <div class="input-group-btn">
            <button class="btn btn-default" id="ver" type="submit">
                <i>imprimir corte semanal</i>
          </button>
        </div>
    </div>
 <form class="form-group" action="ver" method="get">
      @csrf {{--justo aqui--}}
      <div class="input-group">
                  <label>Buscar EL Corte de semana</label>
     <div class="input-group">

            <input type="number" class="form-control" name="numerosemana" placeholder="Search">
      <div class="input-group-btn">
            <button class="btn btn-default"  type="submit">
                <i>buscar</i>
          </button>
        </div>
      </div>
    </form>


    <form class="form-group" action="Fecha" method="post">
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
    </form>
    <br>
    <br>
    <form class="form-group" action="colegiaturadeldia" method="post">
      @csrf {{--justo aqui--}}
     
<div class="input-group">
              </div>
            <div class="input-group">
        <center> <button class="btn btn-info">Ingreso del dia</button></center>
          
        </div>
    </div>
    </form>
    <br>


<!-- tabla de inicio -->
<div class="container">
  <h2>Lista Pago de Colegiatura</h2>          
  <table class="table">
    <thead>
      <tr class='success'>
        <th>Folio</th>
        <th>Matricula del Alumno</th>
        <th>Nombre de Alumno</th>
        <th>Responsable del cobro</th>
        <th>Fecha de pago</th>
        <th>Pago</th>
      </tr>
    </thead>
    <tbody id="tabla_resultados">
             @foreach ($tkm as $lista)
            <tr class="info">
              <!-- <?php $fo=DB::table('folios')->where("Fechadecobro",$datos)->get();  ?>
                @foreach($folio as $folios)
                  @if($folios->id_alumno==$lista->Alumno_id)
                  <td>
                     {{$folios->id}}
                  </td>
                  @endif
                @endforeach -->
              
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

<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  
  $(document).ready(function(){
        $('#ver').click(function(){
           var semana=document.getElementById('busacar').value;
           $.ajax({

              datatype: 'JSON',
               url: '/vercolegiaturas/'+semana,
               type: 'get',
               success: function(response){
                   if(response){
                     console.log('obtuvimos los datos');
                    console.log(response);
                   }else{
                       console.log('Error en la busqueda');
                   }
               }
           }); 
        });
    });
</script>