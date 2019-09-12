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
        if ( isset($params['ejercicio_id']) && trim($params['ejercicio_id'] !== '') ) {
            $query->where('ejercicio_id', 'LIKE', trim($params['ejercicio_id']) . '%');
        }

    //     if ( isset($params['genero']) && trim($params['genero'] !== '') ) {
    //        $query->where('genero', 'LIKE', trim($params['genero']) . '%');
    //    }

    //    if ( isset($params['fechaDeNac']) && trim($params['fechaDeNac']) !== '' )
    //    {
    //        $query->where('fechaDeNac', '=', trim($params['fechaDeNac']));
    //    }
    //    if ( isset($params['usuario']) && trim($params['usuario']) !== '' )
    //    {
    //        $query->where('usuario', '=', trim($params['usuario']));
    //    }

        return $query;
    }

}
