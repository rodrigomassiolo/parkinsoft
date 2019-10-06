<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ejercicio;

class AbmEjercicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $params = $request->except('_token');
        session()->flashInput($request->input());
        if($api){
            $ejercicio = Ejercicio::filter($params)->get();
            return array("qty"=>count($ejercicio),"ejercicios"=>$ejercicio);
        }
        $ejercicio = Ejercicio::filter($params)->paginate(10);        
         return view('abmEjercicio.index',compact('ejercicio'))
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
         return view('abmEjercicio.create');
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
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required'
        ]);

        $ejercicio = Ejercicio::create([
            'nombre' => $request['nombre'],
            'descripcion' => $request['descripcion']
        ]);

        if($api){ return $ejercicio; }

        return redirect()->route('abmEjercicio.index')
                        ->with('success','Paciente creado correctamente.');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ejercicio = Ejercicio::findOrFail($id);
        return view('abmEjercicio.show',compact('ejercicio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ejercicio = Ejercicio::findOrFail($id);
        return view('abmEjercicio.edit',compact('ejercicio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required'
        ]);

        $ejercicio = Ejercicio::findOrFail($id);

        $ejercicio->update($request->all());
        if($api) { return $ejercicio; }

        return redirect()->route('abmEjercicio.index')
                        ->with('success','Ejercicio modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $ejercicio = Ejercicio::where('id',$id)->first();
        
        $ejercicio->delete();

        if($api){ return 'ok'; }

        return redirect()->route('abmEjercicio.index')
                           ->with('success','Ejercicio eliminado correctamente');
    }
}
