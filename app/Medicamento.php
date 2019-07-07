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
    protected $fillable = ['nombre', 'numero', 'fechaConHora', 'booleano', 'fecha', 'Letra', 'commentId', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo('App\Comment', 'commentId');
    }
}
