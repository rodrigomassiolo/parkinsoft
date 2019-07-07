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
})->name('welcome');;
Route::get('welcome', function () {
    return view('welcome');
})->name('welcome');;

Route::get('/dash', function () {
    return view('dash');
});

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/client', 'ClientController@index')->middleware('auth');

Route::get('texto', function () {
    return 'Un texto!';
});

Route::get('contact', 'TicketsController@create');
Route::post('contact', 'TicketsController@store');
Route::get('tickets', 'TicketsController@index');
Route::get('tickets/{slug?}', 'TicketsController@show');
Route::get('tickets/{slug?}/edit', 'TicketsController@edit');
Route::post('tickets/{slug?}/edit', 'TicketsController@update');
Route::post('tickets/{slug?}/delete', 'TicketsController@destroy');
Route::post('/comment', 'CommentsController@newComment');

Route::get('sendemail', function () {

    $data = array(
        'name' => "Parki",
    );

    Mail::send('emails.welcome', $data, function ($message) {

        $message->from('martinnviqueira@gmail.com', 'Curso Laravel');

        $message->to('rodrigomassiolo@gmail.com')->subject('gato el que lee');

    });

    return "Tú email ha sido enviado correctamente";

});