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
        echo($request->get('graphicType'));

        //devolver vista con el grafico generado
        
        //return view('PacienteEjercicio.show',compact('PacienteEjercicio'));
    }

    public function download($id)
    {
        $PacienteEjercicio = PacienteEjercicio::findOrFail($id);

        //find the audio graphic with the audio id in pacienteEjercicio

        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename=".pdf"');
        
        //devolver pdf para descargar

    }
}
