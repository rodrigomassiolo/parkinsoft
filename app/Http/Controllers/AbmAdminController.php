<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;
use App\User;

class AbmAdminController extends Controller
{
    public function index(Request $request)
    {

        $params = $request->except('_token');

        session()->flashInput($request->input());

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
        $make1 = \mb_substr($request['nombre'],0,2);
        $make2 = \mb_substr($request['apellido'],0,2);
        $make3 = substr($request['dni'],-3);

        $fill = $make1 . $make2 . $make3;

        $rol = Rol::create([
            'type' => 0,
            'medico_id' => null
        ]);

        User::create([
            'usuario' => $fill,
            'genero' => $request['genero'],
            'nacimiento' => $request['nacimiento'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'rol_id' => $rol['id'],
            'status' => 'A'
        ]);

        return redirect()->route('abmAdmin.index')
                        ->with('success','Paciente creado correctamente.');
        
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
        $request->validate([
            'genero' => 'required',
            'fechaDeNac' => 'required'
        ]);

        $user = User::findOrFail($id);

         $user->update($request->all());
  
        return redirect()->route('abmAdmin.index')
                        ->with('success','No implementado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->update('status','D');
        
        return redirect()->route('abmAdmin.index')
                           ->with('success','Usuario eliminado correctamente');
    }
}
