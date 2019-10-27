<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PacienteEjercicio;
use App\User;
use App\Rol;
use App\Ejercicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PacienteEjercicioController extends Controller
{
    public function indexRealizados(Request $request)
    {
        return $this->index($request,"realizado");
    }
    public function indexAsignados(Request $request)
    {
        return $this->index($request,"asignado");
    }
    public function index(Request $request, $estado = null)
    {

        $api = substr ( $request->path(), 0,3 ) == 'api';
        $params = $request->except('_token');
        
        session()->flashInput($request->input());
        if(!is_null($estado)){
            $params['status'] = $estado;
        }

        $user = Auth::user()->usuario;
        $rol_id = Auth::user()->rol_id;
        $rol = Rol::where('id', $rol_id)->get();
        $pacientes = array();
        if($rol[0]->type == 2){
            $pacientes[] = Auth::user();
            $params['usuario'] = $user;
        }else{
            $pacientes = User::all();
        }
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
        $ejercicio = Ejercicio::all();
        if($estado == "asignado"){
            return view('pacienteEjercicio.indexAsignados',compact('PacienteEjercicio','estado','ejercicio','pacientes'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
        }else{
            return view('pacienteEjercicio.index',compact('PacienteEjercicio','estado','ejercicio','pacientes'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
        }
    }
    /*arma los filtros para la busqueda de users*/
    private function craftFilterRequest($filters)
    {
        $pacienteEjercicioFilters=array(
            'user_id'  => ['l1.user_id','='],
            'ejercicio_id' => ['l1.ejercicio_id','='],
            'created_at_from' => ['l1.updated_at','>='],
            'created_at_to' => ['l1.updated_at','<=']
                        );
        $filterRequest = "";

        foreach ($pacienteEjercicioFilters as $name => $filter) {
            if(isset($filters[$name]))
            {
                $filterRequest = $filterRequest." AND ".$filter[0].$filter[1]."'".$filters[$name]."'";
            }
        }
        return $filterRequest;
    }

    /*Devuelve cantidad y usuarios filtrados*/
    public function indexLevodopa(Request $request)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $jsonReq = json_decode($request->getContent(), true);
        $filterRequest = $this->craftFilterRequest($jsonReq['filters']);

        $query = '';
        $results = DB::select( DB::raw("SELECT
                                        l1.user_id AS user_id,
                                        l1.ejercicio_id AS ejercicio_id,
                                        ej.nombre AS ejercicio_nombre,
                                        ej.descripcion AS ejercicio_descripcion,
                                        l1.id AS pacienteejercicio_OFF_id,
                                        l2.id AS pacienteejercicio_ON_id,
                                        DATE(l1.updated_at) AS fecha
                                        FROM pacienteEjercicio l1
                                        JOIN pacienteEjercicio l2 
                                        ON l1.user_id = l2.user_id
                                        AND l1.ejercicio_id = l2.ejercicio_id
                                        AND DATE(l1.updated_at) =  DATE(l2.updated_at)
                                        AND l1.es_levodopa = 1
                                        AND l2.es_levodopa = 1
                                        AND l1.status = 'realizado'
                                        AND l2.status = 'realizado'
                                        AND l1.modo_levodopa = 'OFF'
                                        AND l2.modo_levodopa = 'ON'
                                        JOIN ejercicio ej ON ej.id = l1.ejercicio_id
                                        WHERE 1=1".$filterRequest
                                        )
                            );
        if($api){
            return $results;  
        }   
        return view('audio.indexLevodopa',compact('ejercicio'));                
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
    public function asignar( Request $request)
    {
        $preset = null;
        if($request->get('paciente_id') != null){
            $preset = $request->get('paciente_id');
        }   
  
        $user = Auth::user()->usuario;
        $rol_id = Auth::user()->rol_id;
        $rol = Rol::where('id', $rol_id)->get();

        if($rol[0]->type == 0 || $rol[0]->type == 1){

            $pacientes = User::whereHas('rol',function($q){
                $q->where('type','=',2);
            })->get();
        }
        else{
            $pacientes = null;
        }
        $ejercicio = Ejercicio::all();

        return view('pacienteEjercicio.asignar',compact('PacienteEjercicio','ejercicio','pacientes','preset'));

    }

    public function store(Request $request){

        $api = substr ( $request->path(), 0,3 ) == 'api';
        $ejercicioPaciente = array('status'=>"asignado");
        $id_ejercicio= 1;

        if($request->get('ejercicio') != null){
            $id_ejercicio= $request->input('ejercicio');
        }  
        else if($request->has('ejercicio')){
            $id_ejercicio= $request->get('ejercicio');
        }
        $ejercicio = Ejercicio::where('id',$id_ejercicio)->first();
        if(!$ejercicio){
            return response()->json(['invalid_ejercicio'], 400);
        }
        $ejercicioPaciente['ejercicio_id'] = $id_ejercicio;

        if($request->get('audio_preset_paciente') != null){
            $user = User::findOrFail($request->get('audio_preset_paciente'));
        }  
        else if($request->has('user')){
            $user = User::findOrFail($request->input('user'));
        }
        if(!$user){
            return response()->json(['invalid_usuario'], 400);
        }
        $ejercicioPaciente['user_id'] = $user->id;

        if($request->has('es_levodopa')){
            $ejercicioPaciente['es_levodopa'] = $request->input('es_levodopa');
        }
        if($request->has('modo_levodopa')){
            $ejercicioPaciente['modo_levodopa'] = $request->input('modo_levodopa');
        }
        $ejercicioPaciente = PacienteEjercicio::create($ejercicioPaciente);

        if($api){ return $ejercicioPaciente; }

        return redirect()->route('abmUser.index')
        ->with('success','Asignación creada correctamente.');

    }
    public function realizarEjercicio(Request $request)
    {
        $preset = null;
        if($request->get('pacienteEjercicio') != null){
            $pacienteEjercicio_id= $request->get('pacienteEjercicio');
            $PacienteEjercicio = PacienteEjercicio::findOrFail($pacienteEjercicio_id);
            $ejercicio = Ejercicio::findOrFail($PacienteEjercicio->ejercicio_id);
            $pacientes = User::findOrFail($PacienteEjercicio->user_id);
        }
        else{    
            return redirect()->route('listaDeEjerciciosAsignados');
        }
        return view('pacienteEjercicio.realizarEjercicio',compact('pacienteEjercicio_id','ejercicio','pacientes'));
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
