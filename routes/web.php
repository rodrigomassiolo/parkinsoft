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
})->name('welcome');

Route::get('welcome', function () {
    return view('welcome');
})->name('welcome');
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/client', 'ClientController@index')->middleware('auth');

Route::get('texto', function () {
    return 'Un texto!';
});

Route::get('/dash', function () {return view('dash');})->middleware('auth');
Route::get('contact', 'TicketsController@create');
Route::post('contact', 'TicketsController@store');
Route::get('tickets', 'TicketsController@index')->middleware('auth');
Route::get('tickets/{slug?}', 'TicketsController@show')->middleware('auth');
Route::get('tickets/{slug?}/edit', 'TicketsController@edit')->middleware('auth');
Route::post('tickets/{slug?}/edit', 'TicketsController@update')->middleware('auth');
Route::post('tickets/{slug?}/delete', 'TicketsController@destroy')->middleware('auth');
Route::post('/comment', 'CommentsController@newComment')->middleware('auth');

Route::get('sendemail', function () {

    $data = array(
        'name' => "Parki",
    );

    Mail::send('emails.welcome', $data, function ($message) {

        $message->from('martinnviqueira@gmail.com', 'Curso Laravel');

        $message->to('rodrigomassiolo@gmail.com')->subject('gato el que lee');

    });

    return "Tú email ha sido enviado correctamente";

})->middleware('auth');


Route::get('/ls/{param?}', function($param='-a') {

    exec("/var/www/html/parkinsoft/scripts/exampleScript.sh \"${param}\"",$lineasLn);
    $resultado = '';
    foreach($lineasLn as $linea){
    $resultado = $resultado.$linea.'<br>';
    }
    return $resultado;
    });