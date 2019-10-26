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
|Middlewares
|   ->middleware('admin');
|   ->middleware('medico');
|   ->middleware('paciente');
*/
use Illuminate\Http\Request;
use App\Rol;
use App\PacienteEjercicio;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('setlocale/{locale}', function ($locale) {
	if (in_array($locale, \Config::get('app.locales'))) {
	  session(['locale' => $locale]);
	}
	return redirect()->back();
  });

Auth::routes();

Route::Get('infosite','InfoController@infosite')->name('infosite');

Route::Get('infoproj','InfoController@infoproj')->name('infoproj');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/client', 'ClientController@index')->middleware('auth');
	
Route::get('/dash', function () {return view('dash');})->middleware('admin');
Route::get('contact', 'TicketsController@create')->name('contact');
Route::post('contact', 'TicketsController@store');
Route::get('tickets', 'TicketsController@index')->middleware('auth')->name('tickets');
Route::get('tickets/{slug?}', 'TicketsController@show')->middleware('auth');
Route::get('tickets/{slug?}/edit', 'TicketsController@edit')->middleware('auth');
Route::post('tickets/{slug?}/edit', 'TicketsController@update')->middleware('auth');
Route::post('tickets/{slug?}/delete', 'TicketsController@destroy')->middleware('auth');
Route::post('/comment', 'CommentsController@newComment')->middleware('auth');
Route::get('/apk', 'ApkController@download')->middleware('auth')->name('donwloadApk');
Route::get('/ejercicio/download_example/{ejercicio_id}', 'AbmEjercicioController@download_example')->middleware('auth')->name('donwloadAudioExample');
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

Route::get('/user','UserController@index')->middleware('auth')->name('user');
Route::post('/user/update','UserController@update')->middleware('auth')->name('user/update');

Route::get('/user/delete','UserController@delete')->middleware('auth')->name('user/delete');
// Route::post('/user/deleted','UserController@deleted')->middleware('auth')->name('user/deleted');

Route::get('/deleteUser', function () {
	//$user = App\User::find(Auth::user()->id);

	$user = App\User::where('id',Auth::user()->id)->first();

	$rol = App\Rol::where('id', $user['rol_id'])->first();;

	$user->usuario = '';
	$user->email = bcrypt($user->email);
	$user->password = '';
	$user->status = 'D';

	$rol->type = 3;

	$rol->update();
	$user->update();

	Auth::logout();
	
	return Redirect::route('home');

})->middleware('auth')->name('/deleteUser');

Route::post('/resetPassword', function (Request $request) {

    $email = $request->get('email');
    
	$user = App\User::where([
		['email', '=', $email],
	])->take(1)->get();

	if (count($user) != 0)
	{//enviar mail
		$pass = str_random(6);
		$data = array(
			'pass' => $pass,
		);
		$user[0]->password = bcrypt($pass);
		$user[0]->save();

		Mail::send('emails.resetPass', $data, function ($message) use($email) {
			$message->from('support@higia.com.ar', 'support@higia.com.ar');
			$message->to($email)->subject('Cambio de Password');
		});
		return view('emails.process');
	}
	else{
		if($request->get('View') == 1){
			return view('emails.process');
		}
		return "error";
	}
})->name('resetPassword');

Route::get('emailReset',function(){
	return view('auth.passwords.email');
})->name('emailReset');

Route::get('/ls/{param?}', function($param='-a') {

    exec("/var/www/html/parkinsoft/scripts/exampleScript.sh \"${param}\"",$lineasLn);
    $resultado = '';
    foreach($lineasLn as $linea){
    $resultado = $resultado.$linea.'<br>';
    }
    return $resultado;
    });


Route::resource('medicamento','MedicamentoController')->middleware('auth');

Route::post('/sendAudio', 'AudioController@store')->middleware('auth')->name('sendAudio');

Route::post('/sendAudioLevodopa', 'AudioController@storeLevodopa')->middleware('auth')->name('sendAudioLevodopa');

Route::post('/sendLevodopa', 'AudioController@storeLevodopa')->middleware('auth');

Route::get('/audio','AudioController@index')->middleware('auth')->name('audio');

Route::get('/TestLevodopa','AudioController@indexLevodopa')->middleware('auth')->name('TestLevodopa');

Route::resource('medico','MedicoController')->middleware('auth');

Route::resource('abmUser','AbmUserController')->middleware('auth');

Route::get('abmUser/show/{id}','AbmUserController@show')->middleware('auth');

Route::get('/audio/graphic','AudioController@graphic')->middleware('auth')->name('graphic');

Route::resource('abmAdmin','AbmAdminController')->middleware('auth');

Route::resource('abmEjercicio','AbmEjercicioController')->middleware('auth');

Route::get('/listaDeEjercicios','PacienteEjercicioController@index')->middleware('auth')->name('listaDeEjercicios');

Route::get('/listaDeEjercicios/show/{id}','PacienteEjercicioController@show')->middleware('auth');
Route::get('/listaDeEjercicios/download/{id}','PacienteEjercicioController@download')->middleware('auth');
Route::post('/ejercicioPacienteAsignar','PacienteEjercicioController@index')->middleware('auth')->name('ejercicioPacienteAsignar');




Route::post('/audio/processAudio','AudioController@processAudio')->middleware('auth');

Route::get('AvailableAudio/{id}', function($id){
	$response = $id;

	 $comparable = PacienteEjercicio::findOrFail($response);

	if (!$id) {
        $html = '<option value="">'.trans('parkinsoft.pleaseSelect').'</option>';
    } else {
        $html = '';
		$result = 
			PacienteEjercicio::where('user_id',"=", $comparable->user_id)->where("id","<>",$comparable->id)
			->whereHas('ejercicio',function($q) use($comparable){
			$q->where('nombre',"=",$comparable->ejercicio->nombre);
		})->get();;

        foreach ($result as $res) {
				$html .= '<option value="'.$res->id.'">'.$res->created_at.'</option>';
        }
    }

     return response()->json(['html' => $html]);
})->middleware('auth');;


Route::get('/GetUser', function(Request $request){
	
	$search = $request->get('search');

	$response = \App\User::where('email', 'like', '%' . $search . '%')
    			->orWhere('usuario', 'like', '%' . $search . '%')->get();

	$item=[];
	foreach($response as $r){

		$added = ['id' => $r["id"],'text' =>  $r["usuario"].'-'.$r["email"]];

		array_push($item,$added);
	}

	$response = ['items' => $item];


     return response()->json($response);
})->middleware('auth');


Route::resource('operacion','OperacionController')->middleware('auth');

Route::get('/BaseDeDatos','BaseDeDatosController@index')->middleware('auth')->name('BaseDeDatos');
Route::get('/BaseDeDatos/showColumnsFromTable','BaseDeDatosController@showColumnsFromTable')
->middleware('auth');

Route::get('/BaseDeDatos/showIndexesFromTable','BaseDeDatosController@showIndexesFromTable')
->middleware('auth');

Route::post('/BaseDeDatos/setIndex','BaseDeDatosController@setIndex')
->middleware('auth');

Route::post('/BaseDeDatos/deleteIndex','BaseDeDatosController@deleteIndex')
->middleware('auth');

Route::get('/BaseDeDatos/getColumnSelect','BaseDeDatosController@getColumnSelect')
->middleware('auth');
