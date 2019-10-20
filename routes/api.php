<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
/*ABM Admin*/
Route::post('/admin', 'AbmAdminController@index')->middleware('auth:api');
Route::post('/admin/register', 'AbmAdminController@store')->middleware('auth:api');
Route::post('/admin/update/{id}', 'AbmAdminController@update')->middleware('auth:api');
Route::post('/admin/destroy/{id}', 'AbmAdminController@destroy')->middleware('auth:api');

/*ABM Usuarios*/
Route::get('apilogin/{email}/{password}','API\\UsuarioController@apilogin');
Route::post('/resetPassword','API\\UsuarioController@resetPassword');
Route::post('/updatePassword','API\\UsuarioController@updatePassword')->middleware('auth:api');
Route::get('/userActual', 'API\\UsuarioController@show')->middleware('auth:api');

/*ABM Pacientes*/
Route::get('/pacienteActual', 'API\\PacienteController@show')->middleware('auth:api');
Route::post('/paciente', 'API\\PacienteController@index')->middleware('auth:api');
Route::post('/paciente/register', 'API\\PacienteController@store');
Route::post('/paciente/update', 'API\\PacienteController@update')->middleware('auth:api');
Route::post('/paciente/destroy/{id}', 'API\\PacienteController@destroy')->middleware('auth:api');

/*ABM Medicos*/
Route::get('/medicoActual', 'API\\MedicoController@show')->middleware('auth:api');
Route::post('/medico', 'API\\MedicoController@index')->middleware('auth:api');
Route::post('/medico/register', 'API\\MedicoController@store');
Route::post('/medico/update', 'API\\MedicoController@update')->middleware('auth:api');
Route::post('/medico/destroy/{id}', 'API\\MedicoController@destroy')->middleware('auth:api');

/*ABM Ejercicios*/
Route::post('/ejercicio', 'AbmEjercicioController@index')->middleware('auth:api');
Route::post('/ejercicio/register', 'AbmEjercicioController@store')->middleware('auth:api');
Route::post('/ejercicio/update/{id}', 'AbmEjercicioController@update')->middleware('auth:api');
Route::post('/ejercicio/destroy/{id}', 'AbmEjercicioController@destroy')->middleware('auth:api');

/*ABM Operaciones*/
Route::post('/operacion', 'OperacionController@index')->middleware('auth:api');
Route::post('/operacion/register', 'OperacionController@store')->middleware('auth:api');
Route::post('/operacion/update/{id}', 'OperacionController@update')->middleware('auth:api');
Route::post('/operacion/destroy/{id}', 'OperacionController@destroy')->middleware('auth:api');


/*Envio de Audios*/
Route::post('/sendAudio', 'AudioController@store')->middleware('auth:api');
Route::post('/processAudio', 'AudioController@processAudio')->middleware('auth:api');

/*PacienteEjercicio*/
Route::post('/pacienteEjercicio', 'API\\PacienteEjercicioController@index');

/*Apk*/
Route::get('/apk','ApkController@download')->middleware('auth:api');

/*BaseDeDatos*/
Route::get('/showTables','BaseDeDatosController@showTables')->middleware('auth:api');
Route::post('/showColumnsFromTable','BaseDeDatosController@showColumnsFromTable')->middleware('auth:api');
Route::post('/showIndexesFromTable','BaseDeDatosController@showIndexesFromTable')->middleware('auth:api');
Route::post('/setIndex','BaseDeDatosController@setIndex')->middleware('auth:api');
Route::post('/deleteIndex','BaseDeDatosController@deleteIndex')->middleware('auth:api');

/*ABM Tickets*/
Route::post('/ticket', 'TicketsController@index')->middleware('auth:api');
Route::post('/ticket/register', 'TicketsController@store')->middleware('auth:api');
Route::post('/ticket/update/{slug}', 'TicketsController@update')->middleware('auth:api');