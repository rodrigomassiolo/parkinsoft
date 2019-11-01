<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anotador extends Model
{
    protected $fillable = ['id','title','user_id'];
    protected $table = 'anotador';
    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id');
    }

    public function User(){
        return $this->belongsTo('App\User');//lo relaciona con el modelo de user
    }
    
    public function getTitle(){
        return $this->title;
    }

    public function scopeFilter($query, $params)
    {
        if ( isset($params['id']) && trim($params['id'] !== '') ) {
            $query->where('id', '=', trim($params['id']));
        }

        if ( isset($params['user_id']) && trim($params['user_id'] !== '') ) {
            $query->where('user_id', '=', trim($params['user_id']));
        }
        if ( isset($params['title']) && trim($params['title'] !== '') ) {
           $query->where('title', 'LIKE','%'. trim($params['title']) . '%');
       }

       if ( isset($params['created_after']) && trim($params['created_after']) !== '' )
       {
           $query->where('created_at', '>=', trim($params['created_after']));
       }
       if ( isset($params['created_up_to']) && trim($params['created_up_to']) !== '' )
       {
           $query->where('created_at', '<=', trim($params['created_up_to']));
       }
        return $query;
    }
    //protected $table ='nombredeTabla'; //si la tabla de BD se llama distinto al Model
    //protected $primaryKey = 'flight_id'; //si el id del modelo no se llama "id"
    //protected $keyType = 'string'; //si el tipo de id no es int
}
