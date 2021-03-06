<?php

namespace App\Http\Controllers;

use App\Medicamento;
use App\Comment;
use Illuminate\Http\Request;
use App\MedicamentoSearch\MedicamentoSearch;

class MedicamentoController extends Controller
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
            $medicamento = Medicamento::filter($params)->get();
            return array("qty"=>count($medicamento),"medicamentos"=>$medicamento);
        }
        $medicamento = Medicamento::filter($params)->paginate(10);

        return view('medicamento.index',compact('medicamento'))
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
        return view('medicamento.create');
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
        ]);
  
        $medicamento = new Medicamento(array(
            'nombre' => $request->get('nombre'),
            'numero' => 1,
            'fechaConHora' => '2019-07-07',
            'booleano' => true,
            'commentId' => 2,
            'fecha' => '2019-07-07',
            'Letra' => 'A'
       ));

       $medicamento->save();

       if($api){ return $medicamento; }

        return redirect()->route('medicamento.index')
                        ->with('success','Medicamento creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Medicamento  $medicamento
     * @return \Illuminate\Http\Response
     */
    public function show(Medicamento $medicamento)
    {
        //
        return view('medicamento.show',compact('medicamento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Medicamento  $medicamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Medicamento $medicamento)
    {
        //
        return view('medicamento.edit',compact('medicamento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Medicamento  $medicamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medicamento $medicamento)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $request->validate([
            'nombre' => 'required',
        ]);
  
        $medicamento->update($request->all());
        if($api) { return $medicamento; }
  
        return redirect()->route('medicamento.index')
                        ->with('success','Medicamento modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Medicamento  $medicamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $medicamento = Medicamento::where('id',$id)->first();
        $medicamento->delete();
       
        if($api){ return 'ok'; }

        return redirect()->route('medicamento.index')
                        ->with('success','Medicamento eliminado correctamente');
    }
}
