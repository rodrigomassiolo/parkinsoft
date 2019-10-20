<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    use SoftDeletes;
         /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ejercicio';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['nombre','descripcion'];

    public function scopeFilter($query, $params)
    {
        if ( isset($params['nombre']) && trim($params['nombre'] !== '') ) {
            $query->where('nombre', 'LIKE', '%' . trim($params['nombre']) . '%');
        }

        if ( isset($params['descripcion']) && trim($params['descripcion'] !== '') ) {
           $query->where('descripcion', 'LIKE','%'. trim($params['descripcion']) . '%');
       }
       
        return $query;
    }
}
