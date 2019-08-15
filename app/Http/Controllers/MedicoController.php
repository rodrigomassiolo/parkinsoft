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

        $medico = Medico::filter($params)->paginate(10);

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
            'nombre' => 'required',
            'apellido' => 'required',
            'matricula' => 'required',
            'dni' => 'required'
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
        'type' => 2,
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

        return redirect()->route('medico.index')
                        ->with('success','Medico creado correctamente.');
        
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
        //
        // $request->validate([
        //     'nombre' => 'required',
        //     'apellido' => 'required',
        //     'matricula' => 'required'
        // ]);
  
        // $medico->update($request->all());
  
        // return redirect()->route('medico.index')
        //                 ->with('success','Medico modificado correctamente');
        return redirect()->route('medico.index')
                        ->with('success','Falta implementar');
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

           $user->delete();

           $rol->delete();

           $medico->delete();
           return redirect()->route('medico.index')
                           ->with('success','Medico eliminado correctamente');
    }
}
