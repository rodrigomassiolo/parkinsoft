<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PacienteEjercicio;

class PacienteEjercicioController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->except('_token');

        session()->flashInput($request->input());

        $PacienteEjercicio = PacienteEjercicio::filter($params)->paginate(10);

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
        
        return app()->call('App\Http\Controllers\AudioController@processAudio', [$request]);

    }
}
