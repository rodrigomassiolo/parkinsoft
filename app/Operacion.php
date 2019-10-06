<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operacion extends Model
{
    protected $table = 'operacion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha', 'user_id', 'descripcion'
    ];

    public function scopeFilter($query, $params)
    {
        if ( isset($params['user_id']) && trim($params['user_id'] !== '') ) {
            $query->where('user_id', '=', trim($params['user_id']));
        }
        return $query;
    }
}
