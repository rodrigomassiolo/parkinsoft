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
        'usuario', 'genero', 'nacimiento', 'email', 'password','rol_id','status'
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

    public function scopeFilter($query, $params)
    {
        if ( isset($params['email']) && trim($params['email'] !== '') ) {
            $query->where('email', 'LIKE', trim($params['email']) . '%');
        }

        if ( isset($params['genero']) && trim($params['genero'] !== '') ) {
           $query->where('genero', 'LIKE', trim($params['genero']) . '%');
       }

       if ( isset($params['fechaDeNac']) && trim($params['fechaDeNac']) !== '' )
       {
           $query->where('fechaDeNac', '=', trim($params['fechaDeNac']));
       }
        return $query;
    }


}
