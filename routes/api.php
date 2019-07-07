<?php

use Illuminate\Http\Request;

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
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('posts', function () {
	return App\Post::all();
})->middleware('auth:api');

Route::get('clients/posts', function () {
	return App\Post::all();
})->middleware('client');

Route::post('clients/posts', function (Request $request) {
	App\Post::create([
		'title' => $request->input('title'),
		'body' => $request->input('body')
	]);

	return ['status' => 200];
})->middleware('client');
/*
//ejemplo de como se reciben las variables y como se usan
//en este caso en la URI llegan mail y password
//en el body del request llega un JSON
//ver en postman la request Example

Route::get('example/{mail}/{password}', function ($mail,$password,Request $request) {
	$respuesta ="mail 1".$mail;
	$respuesta =$respuesta."pass 1".$password;

	$jsonReq = json_decode($request->getContent(), true);//suponiendo que el body de la request es json
	foreach ($jsonReq as $key => $value) {
		$respuesta =$respuesta.$key." ".$value;
	}
	return $respuesta;
});
*/

/*
//login
//recibe email y password
//devuelve info del Client necesa
//	{
//		"id" =>$client->id,
//		"secret" => $secret,
//		"status" =>"nuevo"
//	}
*/

/*
Route::get('login', function (Request $request) {
	$jsonReq = json_decode($request->getContent(), true);//suponiendo que el body de la request es json

	if (!Auth::attempt(array('email' => $jsonReq['email'], 'password' => $jsonReq['password'])))
	{
		return "Error: Credenciales Incorrectas";
	}

	$user = App\User::where([
		['email', '=', $jsonReq['email']],
	])->take(1)->get();
	
	$client = \Laravel\Passport\Client::where([
												['user_id', '=', $user[0]->id],
												['password_client', '=', 1]
											 ])->take(1)->get();
	if(count($client) == 0){
		$secret = str_random(40);
		$client = new \Laravel\Passport\Client;
		$client->user_id = $user[0]->id;
		$client->name = $user[0]->name.'PasswordClient';
		$client->secret = $secret;
		$client->redirect = "http://localhost/";
		$client->personal_access_client = false;
		$client->password_client = true;
		$client->revoked= false;
		$client->save();
		$respuesta = array(
			"id" =>$client->id,
			"secret" => $secret,
			"status" =>"nuevo"
		);
	}else {
		$respuesta = array(
			"id" =>$client[0]['id'],
			"secret" => $client[0]['secret'],
			"status" =>"viejo"
		);
	}
	return json_encode($respuesta);
});*/



Route::get('login/{mail}/{password}', function ($mail,$password) {
	//$jsonReq = json_decode($request->getContent(), true);//suponiendo que el body de la request es json

	if (!Auth::attempt(array('email' => $mail, 'password' => $password)))
	{
		return "Error: Credenciales Incorrectas";
	}

	$user = App\User::where([
		['email', '=', $mail],
	])->take(1)->get();
	
	$client = \Laravel\Passport\Client::where([
												['user_id', '=', $user[0]->id],
												['password_client', '=', 1]
											 ])->take(1)->get();
	if(count($client) == 0){
		$secret = str_random(40);
		$client = new \Laravel\Passport\Client;
		$client->user_id = $user[0]->id;
		$client->name = $user[0]->name.'PasswordClient';
		$client->secret = $secret;
		$client->redirect = "http://localhost/";
		$client->personal_access_client = false;
		$client->password_client = true;
		$client->revoked= false;
		$client->save();
		$respuesta = array(
			"id" =>$client->id,
			"secret" => $secret,
			"status" =>"nuevo"
		);
	}else {
		$respuesta = array(
			"id" =>$client[0]['id'],
			"secret" => $client[0]['secret'],
			"status" =>"viejo"
		);
	}
	return json_encode($respuesta);
});