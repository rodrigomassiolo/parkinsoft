<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Rol;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'usuario' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:8',
            'genero' => 'required|string|max:1',
            'nacimiento' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $make1 = \mb_substr($data['nombre'],0,2);
        $make2 = \mb_substr($data['apellido'],0,2);
        $make3 = substr($data['dni'],-3);

        $fill = $make1 . $make2 . $make3;

        $rol = Rol::create([
            'type' => 2,
            'medico_id' => null
        ]);

        return User::create([
            'usuario' => $fill,
            'genero' => $data['genero'],
            'nacimiento' => $data['nacimiento'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'rol_id' => $rol['id'],
            'status' => 'A'
        ]);
    }
}
