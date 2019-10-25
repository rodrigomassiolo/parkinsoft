<?php

namespace App\Http\Controllers;
use App\Operacion;
use Illuminate\Http\Request;

class OperacionController extends Controller
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
        if($api){
            $operacion = Operacion::filter($params)->get();
            return array("qty"=>count($operacion),"operaciones"=>$operacion);
        }
        $operacion = Operacion::filter($params)->paginate(10);

        return view('operacion.index',compact('operacion'))
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
        return view('operacion.create');
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
            'fecha' => 'required',
            'user_id' => 'required',
            'descripcion' => 'required'
        ]);
  
        $operacion = new Operacion(array(
        'fecha' => $request->get('fecha'),
        'user_id' => $request->get('user_id'),
        'descripcion' => $request->get('descripcion')
       ));

       $operacion->save();

       if($api){ return $operacion; }

        return redirect()->route('operacion.index')
                        ->with('success','Operacion creada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Operacion  $operacion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $operacion = Operacion::findOrFail($id);
        return view('operacion.show',compact('operacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Operacion  $operacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $operacion = Operacion::findOrFail($id);
        return view('operacion.edit',compact('operacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Operacion  $operacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $request->validate([
            'fecha' => 'required',
            'user_id' => 'required',
            'descripcion' => 'required'
        ]);
        $operacion = Operacion::findOrFail($id);
        $operacion->update($request->all());
        if($api) { return $operacion; }
  
        return redirect()->route('operacion.index')
                        ->with('success','Operacion modificada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Operacion  $operacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $operacion = Operacion::where('id',$id)->first();
        $operacion->delete();
       
        if($api){ return 'ok'; }

        return redirect()->route('operacion.index')
                        ->with('success','Operacion eliminada correctamente');
    }
}
