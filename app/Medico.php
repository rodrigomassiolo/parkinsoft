<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
      /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'medico';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['nombre','apellido','matricula','dni'];

    public function scopeFilter($query, $params)
    {
        if ( isset($params['nombre']) && trim($params['nombre'] !== '') ) {
            $query->where('nombre', 'LIKE', trim($params['nombre']) . '%');
        }

        if ( isset($params['apellido']) && trim($params['apellido'] !== '') ) {
           $query->where('apellido', 'LIKE', trim($params['apellido']) . '%');
       }

       if ( isset($params['matricula']) && trim($params['matricula'] !== '') ) {
           $query->where('matricula', 'LIKE', trim($params['matricula']) . '%');
       }
        return $query;
    }
}
