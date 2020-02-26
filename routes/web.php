<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('Alumnos', function(){
	return view('itm.index3');
});

Route::get('/Registro de producto/', function(){
	return view('itm.index2');
});

Route::get('Actualizar_datos', function()
	{
		return view('itm.index1');
	});
Route::get('/Recibo', function()
	{
		return view('itm.index5');
	});
Route::get('/Recibodeventa/',function(){
	return view('itm.index6');

});

Route::get('/Siguimiento/',function(){
	return view('itm.ingreso');
});

Route::get('/Colegiatrura/',function(){
	return view('itm.Colegiatura');
});

Route::get('/lista del inventario/','VentasController@ListadeProductos');
Route::get('/Resivo/{id}','AlumnosRegistroController@Incripcion');
Route::get('/busqueda/{id}','AlumnosRegistroController@busqueda');
Route::get('/guardar/{id}','AlumnosRegistroController@Guardardatos');
Route::get('/veregistro/{datos}','VentasController@RegistrosAxaj');
Route::get('/vercolegiaturas/{dato}','VentasController@vercolegiaturasaxaj');
Route::get('/Actulizardatos/','AlumnosRegistroController@ActualizarAlumnosajax');
Route::get('/BuscarParaActualizar/{id}','AlumnosRegistroController@BuscarAlunosActualizarAjax');
Route::POST('/Registro_de_productos','VentasController@RegistroDeProductos');

Route::POST('/regist', 'loginController@Registro');
Route::POST('/login','loginController@Login');
Route::POST('/RegistrosAlumnos', 'AlumnosRegistroController@RegistroAlumnos');
Route::get('/ventas/','VentasController@IngresarVentas');
Route::get('/imprimir','AlumnosRegistroController@imprimir');
Route::get('/Adelantar/{id}','AlumnosRegistroController@AdelantarSemanaAjax');

Route::POST('colegiaturadeldia','VentasController@Ingresospordia');
Route::POST('imprimiendocortedia','VentasController@IMprimirigresos');

Route::POST('Productos','VentasController@Productosdia');

Route::get('listadeproductossemanales','VentasController@cortesemanadeproductosss');


Route::get('buscarproductospordia','VentasController@buscandofecha');
//funcion de emprimir


Route::get('imprimirproductos','VentasController@imprimircortedeldia');
Route::POST('Fecha','VentasController@mostracorteporfecha');

Route::get('imprimirfec', 'VentasController@imprimeporfecha');
Route::get('improc','VentasController@improduct');

Route::get('ver','VentasController@cortesemanal');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
