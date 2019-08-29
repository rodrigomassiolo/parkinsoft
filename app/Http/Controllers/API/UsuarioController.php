<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Rol;
use Illuminate\Support\Facades\Mail;
class UsuarioController extends Controller
{
    public function apilogin ($email,$password) {

        if (!Auth::attempt(array('email' => $email, 'password' => $password)))
        {
            return "Error: Credenciales Incorrectas";
        }
    
        $user = User::where([
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
    }
    public function resetPassword (Request $request) {
    
        $jsonReq = json_decode($request->getContent(), true);
        $user = User::where([
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
    }
    public function updatePassword (Request $request) {
    
        $jsonReq = json_decode($request->getContent(), true);
        $actualUser = $request->user();
    
        $user0 = User::where([
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
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $rol = Rol::where('id', $user->rol_id)->first();
        $user->Rol = $rol;
        if(isset($rol->medico_id)){
            $medico = Medico::where('id', $rol->medico_id)->first();
            $user->Rol->Medico = $medico;
        }
        return $user;
    }
}
