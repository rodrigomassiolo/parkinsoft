<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PacienteEjercicio extends Model
{

    protected $table = 'PacienteEjercicio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'tipoDeEjercicio', 'audio_id'];
    

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function ejercicio()
    {
        return $this->hasOne('App\Ejercicio','id','tipoDeEjercicio');
    }


    public function scopeFilter($query, $params)
    {
        if ( isset($params['tipoDeEjercicio']) && trim($params['tipoDeEjercicio'] !== '') ) {
            $query->where('tipoDeEjercicio', 'LIKE', trim($params['tipoDeEjercicio']) . '%');
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
