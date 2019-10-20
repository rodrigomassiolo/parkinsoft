<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\PacienteEjercicio;
use App\Ejercicio;
use Illuminate\Support\Facades\DB;

class PacienteEjercicioController extends Controller
{
    /*arma los filtros para la busqueda de users*/
    private function craftFilterRequest($filters)
    {
        $pacienteEjercicioFilters=array(
            'id' => ['pacienteEjercicio.id','='],
            'user_id'  => ['user_id','='],
            'ejercicio_id' => ['ejercicio_id','='],
            'status' => ['pacienteEjercicio.status','='],
            'created_at_from' => ['pacienteEjercicio.created_at','>='],
            'created_at_to' => ['pacienteEjercicio.created_at','<=']
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
    public function index(Request $request)
    {
        $jsonReq = json_decode($request->getContent(), true);
        $filterRequest = $this->craftFilterRequest($jsonReq['filters']);

        $query = '';
        $results = DB::select( DB::raw("SELECT pacienteEjercicio.id AS pacienteejercicio_id,
                                        pacienteEjercicio.created_at AS fecha,
                                        users.id AS user_id,
                                        users.usuario AS user_usuario,
                                        ejercicio.id AS ejercicio_id,
                                        ejercicio.nombre AS ejercicio_nombre,
                                        pacienteEjercicio.ultimaMedicacion AS ultimaMedicacion,
                                        users.medicacion AS medicacionPaciente,
                                        pacienteEjercicio.status AS status
                                        FROM pacienteEjercicio
                                        INNER JOIN users on pacienteEjercicio.user_id = users.id
                                        INNER JOIN ejercicio on pacienteEjercicio.ejercicio_id = ejercicio.id AND ejercicio.deleted_at IS NULL
                                        WHERE 1=1".$filterRequest
                                        )
                                        );
                                        return $results;                     
    }
}
