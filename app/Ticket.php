<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['id','title','content','slug','status','user_id','email'];

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

    //protected $table ='nombredeTabla'; //si la tabla de BD se llama distinto al Model
    //protected $primaryKey = 'flight_id'; //si el id del modelo no se llama "id"
    //protected $keyType = 'string'; //si el tipo de id no es int
}
