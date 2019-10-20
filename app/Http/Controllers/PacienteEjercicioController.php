<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PacienteEjercicio;
use App\User;
use App\Ejercicio;

class PacienteEjercicioController extends Controller
{
    public function index(Request $request)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $params = $request->except('_token');
        session()->flashInput($request->input());
        
        $PacienteEjercicio_ = PacienteEjercicio::filter($params)->get();
        $PacienteEjercicio = array();
        foreach ($PacienteEjercicio_ as $key => $value) {
            $ejercicio = Ejercicio::where('id',$value->ejercicio_id)->first();
            if($ejercicio != null){
                $value->ejercicio = $ejercicio;
                $PacienteEjercicio [] = $value;
            }
        }
        if($api){
            return array("qty"=>count($PacienteEjercicio),"PacienteEjercicio"=>$PacienteEjercicio);
        }
         return view('pacienteEjercicio.index',compact('PacienteEjercicio'))
             ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function show($id, Request $request)
    {
        $PacienteEjercicio = PacienteEjercicio::findOrFail($id);

        if(!(isset($request['Energy']))){
            $request['Energy'] = 0;
        }
        if(!(isset($request['eGemaps']))){
            $request['eGemaps'] = 0;
        }
        if(!(isset($request['Chroma']))){
            $request['Chroma'] = 0;
        }
        if(!(isset($request['Audspec']))){
            $request['Audspec'] = 0;
        }
        if(!(isset($request['Prosody']))){
            $request['Prosody'] = 0;
        }
        $request['html'] = 0;
        $request['View'] = 1;
        $request['output'] = 0;
        
        return app()->call('App\Http\Controllers\AudioController@processAudio', [$request]);
    }

    public function download($id, Request $request)
    {
        $PacienteEjercicio = PacienteEjercicio::findOrFail($id);

        if(!(isset($request['Energy']))){
            $request['Energy'] = 0;
        }
        if(!(isset($request['eGemaps']))){
            $request['eGemaps'] = 0; 
        }
        if(!(isset($request['Chroma']))){
            $request['Chroma'] = 0;
        }
        if(!(isset($request['Audspec']))){
            $request['Audspec'] = 0;
        }
        if(!(isset($request['Prosody']))){
            $request['Prosody'] = 0;
        }
      
        $request['html'] = 0;
        $request['View'] = 0;
        $request['output'] = 1;
        
        //return app()->call('App\Http\Controllers\AudioController@processAudio', [$request]);

        return redirect()->action(
            'AudioController@processAudio', $request
        );

    }

    public function store(Request $request){
        $api = substr ( $request->path(), 0,3 ) == 'api';

        $id_ejercicio= 1;
        if($request->has('ejercicio')){
            $id_ejercicio= $request->input('ejercicio');
            $ejercicio = Ejercicio::where('id',$id_ejercicio)->first();
            if(!$ejercicio){
                return response()->json(['invalid_ejercicio'], 400);
            }
        }
        
        if($request->has('user')){
            $user = User::findOrFail($request->input('user'));
            if(!$user){
                return response()->json(['invalid_usuario'], 400);
            }
        }

        $ejercicioPaciente = PacienteEjercicio::create([
            'user_id' => $user->id,
            'ejercicio_id' => $id_ejercicio,
            'status'=>"asignado"
        ]);

        if($api){ return $ejercicioPaciente; }

        return redirect()->route('abmEjercicioPaciente.index')
        ->with('success','Paciente creado correctamente.');

    }

    public function update(Request $request, $id)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $request->validate([
            'ejercicio_id' => 'required',
            'user_id' => 'required'
        ]);

        $PacienteEjercicio = PacienteEjercicio::findOrFail($id);

        $PacienteEjercicio->update($request->all());
        if($api) { return $PacienteEjercicio; }

        return redirect()->route('pacienteEjercicio.index')
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
        $PacienteEjercicio = PacienteEjercicio::where('id',$id)->first();
        
        $PacienteEjercicio->delete();

        if($api){ return 'ok'; }

        return redirect()->route('pacienteEjercicio.index')
                           ->with('success','Ejercicio eliminado correctamente');
    }
}
