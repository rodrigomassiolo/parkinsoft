<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Rol;
use App\Medico;
use Illuminate\Support\Facades\DB;
class MedicoController extends Controller
{
    /*arma los filtros para la busqueda de users*/
    private function craftFilterRequest($filters)
    {
        $medicoFilters=array(
            'id' => ["users.id",'='],
            'email'  => ["email",'='],
            'genero' => ["genero",'='],
            'usuario' => ["usuario",'='],
            'nacimiento' => ["nacimiento",'='],
            'status' => ["status",'='],
            'nombre' => ["nombre",'='],
            'apellido' => ["apellido",'='],
            'dni' => ["dni",'='],
            'matricula' => ["matricula",'='],
                        );

        $filterRequest = "";

        foreach ($medicoFilters as $name => $filter) {

            if(isset($filters[$name]))
            {
                $filterRequest = $filterRequest." AND ".$filter[0].$filter[1]."'".$filters[$name]."'";
            }
        }
        return $filterRequest;
    }
    /*Devuelve cantidad y usuarios filtrados*/
    public function index(Request $request)
    {        
        $jsonReq = json_decode($request->getContent(), true);
        $filterRequest = $this->craftFilterRequest($jsonReq['filters']);

        $query = '';
        
        $results = DB::select( DB::raw("SELECT  * , users.id as user_id FROM users
                                        INNER JOIN rol ON users.rol_id = rol.id
                                        INNER JOIN medico on rol.medico_id = medico.id
                                        WHERE 1=1".$filterRequest
                                    )
                             );
        $response=array("qty"=>count($results),"medcicos"=>$results);
        return $response;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request) {
        $request->validate([
            'matricula' =>  array(
                'required',
                'regex:/^[0-9]+$/',
                'max:10'
            ),
            'dni' =>  array(
                'required',
                'regex:/^[0-9]+$/',
                'max:8'
            ),
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'genero' => 'required|string|max:1',
            'nacimiento' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        $jsonReq = json_decode($request->getContent(), true);
        if($jsonReq['confirmaPassword'] != $jsonReq['password'])	{
            return "Error: El password no coincide";
        }

        $make1 = \mb_substr($request['nombre'],0,2);
        $make2 = \mb_substr($request['apellido'],0,2);
        $make3 = substr($request['dni'],-3);

        $fill = $make1 . $make2 . $make3;

        $medico = new Medico(array(
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'matricula' => $request->get('matricula'),
            'dni' => $request->get('dni')
       ));
       $medico->save();
        $rol = Rol::create([
            'type' => 1,
            'medico_id' =>  $medico->id
        ]);

        $user = new \App\User;
        $user->usuario = $fill;
        $user->genero = $jsonReq['genero'];
        $user->nacimiento = $jsonReq['nacimiento'];
        $user->email = $jsonReq['email'];
        $user->password = bcrypt($jsonReq['password']);
        $user->rol_id = $rol['id'];
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
        $user->Rol->Medico = $medico;

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
        $rol = Rol::where('id', $user->rol_id)->first();
        $medico = Medico::where('id', $rol->medico_id)->first();
        $user->Rol = $rol;
        $user->Rol->Medico = $medico;
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
        $rol = Rol::where('id',$user->rol_id)->first(); 
        $medico = Medico::where('id',$rol->medico_id)->first(); 
        if($user==null)return "Error";//no es medico
        if($rol==null)return "Error";//no es medico
        if($medico==null)return "Error";//no es medico

        $request->validate([
            'matricula' =>  array(
                'required',
                'regex:/^[0-9]+$/',
                'max:10'
            ),
            'dni' =>  array(
                'required',
                'regex:/^[0-9]+$/',
                'max:8'
            ),
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'genero' => 'required|string|max:1',
            'nacimiento' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users'
        ]);
        
        $user->genero = $jsonReq['genero'];
        $user->nacimiento = $jsonReq['nacimiento'];
        if($user->email != $jsonReq['email']){
            $user->email = $jsonReq['email'];
        }
        
        $medico->matricula=$jsonReq['matricula'];
        $medico->dni=$jsonReq['dni'];
        $medico->nombre=$jsonReq['nombre'];
        $medico->apellido=$jsonReq['apellido'];
       
        $user->save();
        $medico->save();
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
        $medico = Medico::where('id', $rol->medico_id)->first();
        $rol->delete();
        $user->delete();
        $medico->delete();
        return 'ok';
    }
}
