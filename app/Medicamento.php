<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $nombre
 * @property int $numero
 * @property string $fechaConHora
 * @property boolean $booleano
 * @property string $fecha
 * @property string $Letra
 * @property int $commentId
 * @property string $created_at
 * @property string $updated_at
 * @property Comment $comment
 */
class Medicamento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'medicamento';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['nombre','numero','fechaConHora','booleano','fecha','Letra','commentId'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo('App\Comment', 'commentId');
    }

    public function scopeFilter($query, $params)
    {
        if ( isset($params['nombre']) && trim($params['nombre'] !== '') ) {
            $query->where('nombre', 'LIKE', trim($params['nombre']) . '%');
        }

        if ( isset($params['numero']) && trim($params['numero']) !== '' )
        {
            $query->where('numero', '=', trim($params['numero']));
        }

        if ( isset($params['Letra']) && trim($params['Letra']) !== '' )
        {
            $query->where('Letra', '=', trim($params['Letra']));
        }
        return $query;
    }

}
