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

Route::post('/register', function (Request $request) {
	$jsonReq = json_decode($request->getContent(), true);
	if(!$jsonReq['usuario'] && !preg_match('/^[A-Z]{4}\d{3}$/', $jsonReq['usuario'])){
		return "Error: el usuario es requerido y debe tener el formato AAAA123";
	}
	if(!($jsonReq['genero'] && ($jsonReq['genero']=='F' || $jsonReq['genero']=='M'))){
		return "Error: el género es requerido";
	}
	$test_date  = explode('-', $jsonReq['nacimiento']);
	if (! (count($test_date)==3 && checkdate($test_date[1], $test_date[2], $test_date[0])) ) {
		return "Error: la fecha de nacimiento es requerida";
	}
	if (!$jsonReq['email'] && !filter_var($jsonReq['email'], FILTER_VALIDATE_EMAIL)){
		return "Error: la dirección de email es requerida";
	}
	if(!$jsonReq['password']){
		return "Error: el password es requerido";
		if(strlen($jsonReq['password'])<6){
			return "Error: el password debe tener al menos 6 caracteres";
		}
	}
	$user = App\User::where([
		['email', '=', $jsonReq['email']],
	])->take(1)->get();

	if (count($user) != 0)
	{
		return "Error: El email ya fué utilizado";
	}
	$user = App\User::where([
		['usuario', '=', $jsonReq['usuario']],
	])->take(1)->get();

	if (count($user) != 0)
	{
		return "Error: El usuario ya fué utilizado";
	}

	if($jsonReq['confirmaPassword'] != $jsonReq['password'])	{
		return "Error: El password no coincide";
	}
	
	$user = new \App\User;
	$user->usuario = $jsonReq['usuario'];
	$user->genero = $jsonReq['genero'];
	$user->nacimiento = $jsonReq['nacimiento'];
	$user->email = $jsonReq['email'];
	$user->password = bcrypt($jsonReq['password']);
	$user->save();

	$secret = str_random(40);
	$client = new \Laravel\Passport\Client;
	$client->user_id = $user->id;
	$client->name = $user->usuario.'PasswordClient';
	$client->secret = $secret;
	$client->redirect = "higia.com.ar";
	$client->personal_access_client = false;
	$client->password_client = true;
	$client->revoked= false;
	$client->save();

	$user->secret = $secret;

	return json_encode($user);
});

Route::get('apilogin/{email}/{password}', function ($email,$password) {
	//$jsonReq = json_decode($request->getContent(), true);//suponiendo que el body de la request es json

	if (!Auth::attempt(array('email' => $email, 'password' => $password)))
	{
		return "Error: Credenciales Incorrectas";
	}

	$user = App\User::where([
		['email', '=', $email],
	])->take(1)->get();
	
	$client = \Laravel\Passport\Client::where([
												['user_id', '=', $user[0]->id],
												['password_client', '=', 1]
											 ])->take(1)->get();
	if(count($client) == 0){
		$secret = str_random(40);
		$client = new \Laravel\Passport\Client;
		$client->user_id = $user[0]->id;
		$client->name = $user[0]->usuario.'PasswordClient';
		$client->secret = $secret;
		$client->redirect = "higia.com.ar";
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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/resetPassword', function (Request $request) {

	$jsonReq = json_decode($request->getContent(), true);
	$user = App\User::where([
		['email', '=', $jsonReq['email']],
	])->take(1)->get();

	if (count($user) != 0)
	{//enviar mail
		$pass = str_random(6);
		$data = array(
			'pass' => $pass,
		);
		$user[0]->password = bcrypt($pass);
		$user[0]->save();

		Mail::send('emails.resetPass', $data, function ($message) use($jsonReq) {
			$message->from('support@higia.com.ar', 'support@higia.com.ar');
			$message->to($jsonReq['email'])->subject('Cambio de Password');
		});
		return "ok";
	}
	else{
		return "error";
	}
});

Route::post('/updateUser', function (Request $request) {
	$actualUser = $request->user();

	$user0 = App\User::where([
		['id', '=', $actualUser['id']],
	])->take(1)->get();

	if (count($user0) == 0)
	{
		return "error";
	}else {
		$user = $user0[0];
	}

	$jsonReq = json_decode($request->getContent(), true);
	if(!($jsonReq['genero'] && ($jsonReq['genero']=='F' || $jsonReq['genero']=='M'))){
		return "Error: el género es requerido";
	}
	else{
		$user->genero = $jsonReq['genero'];
	}

	$test_date  = explode('-', $jsonReq['nacimiento']);
	if (! (count($test_date)==3 && checkdate($test_date[1], $test_date[2], $test_date[0])) ) {
		return "Error: la fecha de nacimiento es requerida";
	}
	else{
		$user->nacimiento = $jsonReq['nacimiento'];
	}

	if (!$jsonReq['email'] && !filter_var($jsonReq['email'], FILTER_VALIDATE_EMAIL)){
		return "Error: la dirección de email es requerida";
	}else{
		$user->email = $jsonReq['email'];
	}
	$user->save();

	return "ok";

})->middleware('auth:api');

Route::post('/updatePassword', function (Request $request) {

	$jsonReq = json_decode($request->getContent(), true);
	$actualUser = $request->user();

	$user0 = App\User::where([
		['id', '=', $actualUser['id']],
	])->take(1)->get();

	if (count($user0) == 0)
	{
		return "error";
	}else {
		$user = $user0[0];
	}

	 if(!$jsonReq['password']){
		return "Error: el password es requerido";
		if(strlen($jsonReq['password'])<6){
			return "Error: el password debe tener al menos 6 caracteres";
		}
	}
	if($jsonReq['confirmaPassword'] != $jsonReq['password'])	{
		return "Error: El password no coincide";
	}

	$user->password = bcrypt($jsonReq['password']);
	$user->save();
    return "ok";
})->middleware('auth:api');

Route::post('/deleteUser', function (Request $request) {

	$actualUser = $request->user();

	$user0 = App\User::where([
		['id', '=', $actualUser['id']],
	])->take(1)->get();

	if (count($user0) == 0)
	{
		return "error";
	}else {
		$user = $user0[0];
	}
	$user->delete();
    return "ok";
})->middleware('auth:api');

Route::post('/sendAudio', 'AudioController@store')->middleware('auth:api');
Route::post('/sendLevodopa', 'AudioController@storeLevodopa')->middleware('auth:api');

/*

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