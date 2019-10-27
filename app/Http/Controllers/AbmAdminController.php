<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;
use App\User;

class AbmAdminController extends Controller
{
    public function index(Request $request)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $params = $request->except('_token');
        session()->flashInput($request->input());
        if($api){
            $user = User::filter($params)->whereHas('rol',function($q){
                $q->where('type',0);
            })->get();
           
            return array("qty"=>count($user),"users"=>$user);
        }
        $user = User::filter($params)->whereHas('rol',function($q){
            $q->where('type',0);
        })->paginate(10);

         return view('abmAdmin.index',compact('user'))
             ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('abmAdmin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $make1 = \mb_substr($request['nombre'],0,2);
        $make2 = \mb_substr($request['apellido'],0,2);
        $make3 = substr($request['dni'],-3);

        $fill = strtoupper ($make1) . strtoupper ($make2) . $make3;

        $check = User::where('email',$request['email'])->first();

        if($check){
            if($request->get('View')){
                $var = \Lang::get('parkinsoft.adminDuplicateMessageSuccessful');                
                return redirect()->route('abmAdmin.index')
                                ->withSuccess($var);
            }
           
        }
        
        $rol = Rol::create([
            'type' => 0,
            'medico_id' => null
        ]);

        $user = User::create([
            'usuario' => $fill,
            'genero' => $request['genero'],
            'nacimiento' => $request['nacimiento'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'rol_id' => $rol['id'],
            'status' => 'A'
        ]);
        if($api) {
            $user->rol = $rol;
            return $user;
        }

        $var = \Lang::get('parkinsoft.adminNewMessageSuccessful');                
        return redirect()->route('abmAdmin.index')
                        ->withSuccess($var);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('abmAdmin.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('abmAdmin.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';

        $request->validate([
            'genero' => 'required',
            'nacimiento' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());
  
        if($api) {
            $rol = Rol::findOrFail($user->rol_id);
            $user->rol = $rol;
            return $user;
        }

        $var = \Lang::get('parkinsoft.exerciseUpdateMessageSuccessful');                
        return redirect()->route('abmAdmin.index')
                        ->withSuccess($var);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';

        $user = User::where('id',$id)->first();

        $rol = Rol::where('id', $user['rol_id'])->first();

        $user->usuario = '';
        $user->email = bcrypt($user->email);
        $user->password = '';
        $user->status = 'D';

        $rol->type = 3;

        $rol->update();
        $user->update();
        
        if($api){ return 'ok'; }

        $var = \Lang::get('parkinsoft.adminDeleteMessageSuccessful');
        return redirect()->route('abmEjercicio.index')
                        ->withSuccess($var);

    }
}
