<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user()->tokenCan("admin:admin");
});

Route::get('/activacion/{user}','activacionController@activar');


Route::middleware('auth:sanctum')->get('/productos','ProductController@mostrarTodos')->middleware('verificar');
Route::middleware('auth:sanctum')->get('/productos/{producto}','ProductController@mostrar')->middleware('verificar');
Route::middleware('auth:sanctum')->get('/productos/{producto}/comentarios','ProductController@comentarios')->middleware('verificar');
Route::middleware('auth:sanctum')->post('productos/','ProductController@create')->middleware('verificar');
Route::middleware('auth:sanctum')->put('/productos/{producto}/edit','ProductController@modificar')->middleware('verificar');// modificar solo estara disponible para admin
Route::middleware('auth:sanctum')->delete('/productos/{producto}','ProductController@eliminar')->middleware('verificar');//delete solo estara disponible para admin


Route::middleware('auth:sanctum')->get('/comentarios','CommentController@mostrarTodos')->middleware('verificar');
Route::middleware('auth:sanctum')->post('/comentarios/{producto}','CommentController@guardar')->middleware('verificar');
Route::middleware('auth:sanctum')->put('/comentarios/{comentario}/edit','CommentController@modificar')->middleware('verificar');
Route::middleware('auth:sanctum')->delete('/comentarios/{comentario}','CommentController@eliminar')->middleware('verificar');

Route::middleware('auth:sanctum')->post('usuarios/{id}/subirFoto','subirArchivoController@subir');
Route::middleware('auth:sanctum')->get('/usuarios','UserController@usuarios')->middleware('verificar');
Route::middleware('auth:sanctum')->get('/usuarios/{usuario}','UserController@mostrar')->middleware('verificar');
Route::middleware('auth:sanctum')->get('/usuarios/{usuario}/comentarios/','UserController@comentarios_usuario')->middleware('verificar');
Route::middleware('auth:sanctum')->put('/usuarios/{usuario}/edit','UserController@modificar'); // Solo admin
Route::middleware('auth:sanctum')->delete('/usuarios/{usuario}','UserController@eliminar');  // Solo admin


Route::post('registro','UserController@Guardar');
Route::post('Login','AuthController@LogIn');

//Route::middleware('auth:sanctum')->get('users','UserController@mostrar');
Route::middleware('auth:sanctum')->delete('Logout','AuthController@Logout');