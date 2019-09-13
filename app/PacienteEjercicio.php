<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PacienteEjercicio extends Model
{

    protected $table = 'pacienteEjercicio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'ejercicio_id','audio_path','audio_name','audio_ext'];
    
    public function scopeFilter($query, $params)
    {
        
        /**
         * this filter by ejercicio_id and you want to filter by "ejercicio type"
         * Not filter by 2 but by "Repetir A"  
         */
        // if ( isset($params['ejercicio_id']) && trim($params['ejercicio_id'] !== '') ) {
        //     $query->where('ejercicio_id', 'LIKE', trim($params['ejercicio_id']) . '%');
        // }

        if ( isset($params['tipoDeEjercicio']) && trim($params['tipoDeEjercicio'] !== '') ) {
            $query->whereHas('ejercicio', function($query) use($params){
                $query->where('nombre', 'LIKE', trim($params['tipoDeEjercicio']) . '%');
            });
        } 
        
        if ( isset($params['created_at']) && trim($params['created_at']) !== '' )
        {
            $query->where('created_at', '>=', trim($params['created_at']));
        }

        if ( isset($params['usuario']) && trim($params['usuario']) !== '' )
        {
            $query->where('usuario', '=', trim($params['usuario']));
        }

        return $query;
    }

}
