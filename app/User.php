<?php

namespace App;

use Laravel\Passport\HasApiTokens;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Rol;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'name', 'email', 'password',
        'usuario', 'genero', 'nacimiento', 'email', 'password','rol_id','status','medicacion', 'idioma'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rol()
    {
        return $this->hasOne('App\Rol','id','rol_id');
    }

    public function operaciones()
    {
        return $this->hasMany('App\Operacion', 'user_id', 'id');
    }


    public function scopeFilter($query, $params)
    {
        if ( isset($params['email']) && trim($params['email'] !== '') ) {
            $query->where('email', 'LIKE', trim($params['email']) . '%');
        }

        if ( isset($params['genero']) && trim($params['genero'] !== '') ) {
           $query->where('genero', 'LIKE', trim($params['genero']) . '%');
       }

       if ( isset($params['nacimiento']) && trim($params['nacimiento']) !== '' )
       {
           $query->where('nacimiento', '=', trim($params['nacimiento']));
       }
       if ( isset($params['usuario']) && trim($params['usuario']) !== '' )
       {
           $query->where('usuario', 'LIKE', trim($params['usuario']. '%'));
       }
       if ( isset($params['idioma']) && trim($params['idioma']) !== '' )
       {
           $query->where('idioma', 'LIKE', trim($params['idioma']) . '%');
       }
        return $query;
    }

    public function isMedico()
    {
        return ($this->rol->type == 1);
    }


}
