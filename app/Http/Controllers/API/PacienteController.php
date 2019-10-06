<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Rol;
use App\Operacion;

class PacienteController extends Controller
{
    /*arma los filtros para la busqueda de users*/
    private function craftFilterRequest($filters)
    {
        $userFilters=array(
            'id' => ['id','='],
            'email'  => ['email','='],
            'genero' => ['genero','='],
            'usuario' => ['usuario','='],
            'nacimiento' => ['nacimiento','='],
            'status' => ['status','='],
            'idioma' => ['idioma','=']
                        );

        $filterRequest = array();

        foreach ($userFilters as $name => $filter) {

            if(isset($filters[$name]))
            {
                $filter[2] = $filters[$name];
                $filterRequest[] = $filter;
            }
        }
        return $filterRequest;
    }
    /*Devuelve cantidad y usuarios filtrados*/
    public function index(Request $request)
    {
        $jsonReq = json_decode($request->getContent(), true);
        $filterRequest = $this->craftFilterRequest($jsonReq['filters']);
        $users = User::where($filterRequest)->get();

        
        foreach ($users as $key => $value) {
            $rol = Rol::where([['id', '=', $value['rol_id']]])->take(1)->get();
            if($rol[0]->type != 2){
                unset($users[$key]);
                continue;
            }
            $value['rol'] = $rol;

            $operaciones = Operacion::where([['user_id', '=', $value['id']]])->get();
            $value['operaciones'] = $operaciones;
        }
       //$user = User::filter($request)->where('email','<>','')->paginate(10);
        $response=array("qty"=>count($users),"users"=>$users);
        return $response;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request) {
        
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
        $user = User::where([
            ['email', '=', $jsonReq['email']],
        ])->take(1)->get();
    
        if (count($user) != 0)
        {
            return "Error: El email ya fué utilizado";
        }
        $user = User::where([
            ['usuario', '=', $jsonReq['usuario']],
        ])->take(1)->get();
    
        if (count($user) != 0)
        {
            return "Error: El usuario ya fué utilizado";
        }
    
        if($jsonReq['confirmaPassword'] != $jsonReq['password'])	{
            return "Error: El password no coincide";
        }
        
        $rol = Rol::create([
            'type' => 2,
            'medico_id' => null
        ]);

        $user = new \App\User;
        $user->usuario = $jsonReq['usuario'];
        $user->genero = $jsonReq['genero'];
        $user->nacimiento = $jsonReq['nacimiento'];
        $user->email = $jsonReq['email'];
        $user->password = bcrypt($jsonReq['password']);
        $user->rol_id = $rol['id'];
        if($jsonReq['idioma']){
            $user->idioma = $jsonReq['idioma'];
        }
        if($jsonReq['medicacion']){
            $user->medicacion = $jsonReq['medicacion'];
        }
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
        $user->Rol = $rol;
        return json_encode($user);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = $request->user();
        $rol = Rol::where([['id', '=', $user->rol_id]])->take(1)->get();
        $user->Rol = $rol;

        $operaciones = Operacion::where([['user_id', '=', $value['id']]])->get();
        $user->Operaciones = $operaciones;
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request) {
        $jsonReq = json_decode($request->getContent(), true);
    
        $user = User::where('id',$jsonReq['id'])->first(); 
        
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

        if($jsonReq['idioma']){
            $user->idioma = $jsonReq['idioma'];
        }
        if($jsonReq['medicacion']){
            $user->medicacion = $jsonReq['medicacion'];
        }

        $user->save();
    
        return "ok";
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id',$id)->first();

        $rol = Rol::where('id', $user->rol_id)->first();
        $rol->type = 3;
        $rol->update();

        $user->usuario = '';
        $user->email = bcrypt($user->email);
        $user->password = '';
        $user->status = 'D';
        $user->update();

        return 'ok';
    }
}
