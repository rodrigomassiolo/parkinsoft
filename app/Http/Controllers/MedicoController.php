<?php

namespace App\Http\Controllers;

use App\Medico;
use App\Rol;
use App\User;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->except('_token');

        session()->flashInput($request->input());

        $medico = Medico::filter($params)->where('nombre','<>','')->paginate(10);

         return view('medico.index',compact('medico'))
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
        return view('medico.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        'medico_id' => $medico['id']
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

        $var = \Lang::get('parkinsoft.medicNewMessageSuccessful');
        return redirect()->route('medico.index')
                        ->withSuccess($var);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Medico  $medico
     * @return \Illuminate\Http\Response
     */
    public function show(Medico $medico)
    {
        return view('medico.show',compact('medico'));
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Medico  $medico
     * @return \Illuminate\Http\Response
     */
    public function edit(Medico $medico)
    {
        return view('medico.edit',compact('medico'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Medico  $medico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medico $medico)
    {
        
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
            'apellido' => 'required|string|max:255'
        ]);
  
        $medico->update($request->all());


        $var = \Lang::get('parkinsoft.medicUpdateMessageSuccessful');
        return redirect()->route('medico.index')
                        ->withSuccess($var);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Medico  $medico
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medico $medico)
    {

        $rol = Rol::where('medico_id', $medico['id'])->first();;

        $user = User::where('rol_id',$rol['id'])->first();

        $medico = Medico::where('id',$medico['id'])->first();

        $medico->nombre = "";
        $medico->apellido = "";
        $medico->matricula = "";
        $medico->dni = "";

        $user->usuario = '';
        $user->email = bcrypt($user->email);
        $user->password = '';
        $user->status = 'D';

        $rol->type = 3;

        $medico->update();
        $rol->update();
        $user->update();

        $var = \Lang::get('parkinsoft.medicDeleteMessageSuccessful');
        return redirect()->route('medico.index')
                        ->withSuccess($var);
    }
}
