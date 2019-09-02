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

/*Para Usuarios*/
Route::get('apilogin/{email}/{password}','API\\UsuarioController@apilogin');
Route::post('/resetPassword','API\\UsuarioController@resetPassword');
Route::post('/updatePassword','API\\UsuarioController@updatePassword')->middleware('auth:api');
Route::get('/userActual', 'API\\UsuarioController@show')->middleware('auth:api');

/*Envio de Audios*/
Route::post('/sendAudio', 'AudioController@store')->middleware('auth:api');
Route::post('/sendLevodopa', 'AudioController@storeLevodopa')->middleware('auth:api');

Route::get('/ffmpeg/{path}/{name}/{extens}', 'AudioController@ffmpeg');
Route::get('/openSmile/{openSmileScript}/{path}/{name}', 'AudioController@openSmile');
Route::get('/csvToDB/{csvToDBScript}/{user_id}/{path}/{name}', 'AudioController@csvToDB');

/*Para Pacientes*/
Route::get('/pacienteActual', 'API\\PacienteController@show')->middleware('auth:api');
Route::post('/paciente', 'API\\PacienteController@index')->middleware('auth:api');
Route::post('/paciente/register', 'API\\PacienteController@store');
Route::post('/paciente/update', 'API\\PacienteController@update')->middleware('auth:api');
Route::post('/paciente/destroy/{id}', 'API\\PacienteController@destroy')->middleware('auth:api');

/*Para Medicos*/
Route::get('/medicoActual', 'API\\MedicoController@show')->middleware('auth:api');
Route::post('/medico', 'API\\MedicoController@index')->middleware('auth:api');
Route::post('/medico/register', 'API\\MedicoController@store');
Route::post('/medico/update', 'API\\MedicoController@update')->middleware('auth:api');
Route::post('/medico/destroy/{id}', 'API\\MedicoController@destroy')->middleware('auth:api');