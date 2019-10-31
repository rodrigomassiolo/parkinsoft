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
        'user_id', 'ejercicio_id','audio_path','audio_name','audio_ext','ultimaMedicacion','es_levodopa','modo_levodopa','origen_audio','status'];
    
    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }
    public function ejercicio()
    {
        return $this->hasOne('App\Ejercicio','id','ejercicio_id');
    }

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
        
        if ( isset($params['ejercicio_id']) && trim($params['ejercicio_id']) !== '' )
        {
            $query->where('ejercicio_id', '=', trim($params['ejercicio_id']));
        }

        if ( isset($params['created_at']) && trim($params['created_at']) !== '' )
        {
            $query->where('created_at', '>=', trim($params['created_at']));
        }

        if ( isset($params['created_atFrom']) && trim($params['created_atFrom']) !== '' )
        {
            $query->where('created_at', '>=', trim($params['created_atFrom']));
        }
        if ( isset($params['created_atTo']) && trim($params['created_atTo']) !== '' )
        {
            $query->where('created_at', '<=', trim($params['created_atTo']));
        }

        if ( isset($params['user_id']) && trim($params['user_id']) !== '' )
        {
            $query->where('user_id', '=', trim($params['user_id']));
        }
        if ( isset($params['usuario']) && trim($params['usuario']) !== '' )
        {
            $query->whereHas('user', function($query) use($params){
                $query->where('usuario', 'LIKE', trim($params['usuario']) . '%');
            });
            // $query->where('usuario', '=', trim($params['usuario']));
        }
        if ( isset($params['es_levodopa']) && trim($params['es_levodopa']) !== '' )
        {
            $query->where('es_levodopa', '=', trim($params['es_levodopa']));
        }
        
        if ( isset($params['status']) && trim($params['status']) !== '' )
        {
            $query->where('status', '=', trim($params['status']));
        }

        if ( isset($params['modo_levodopa']) && trim($params['modo_levodopa']) !== '' )
        {
            $query->where('modo_levodopa', '=', trim($params['modo_levodopa']));
        }

        if ( isset($params['origen_audio']) && trim($params['origen_audio']) !== '' )
        {
            $query->where('origen_audio', '=', trim($params['origen_audio']));
        }
        
        if ( isset($params['deleted_at']) && trim($params['deleted_at']) !== '' )
        {
            $query->whereHas('ejercicio', function($query) use($params){
                $query->where('deleted_at', null);
            });
        }

        return $query;
    }

    // public static function getMyDateFormat($value)
    // {
    //     return \Carbon\Carbon::createFromFormat($value, 'Y/m/d')->toDateTimeString();
    // }

}

