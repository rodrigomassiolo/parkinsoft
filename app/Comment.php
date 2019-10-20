<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id'];

    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }

    public function scopeFilter($query, $params)
    {
        if ( isset($params['id']) && trim($params['id'] !== '') ) {
            $query->where('id', '=', trim($params['id']));
        }
        if ( isset($params['post_id']) && trim($params['post_id'] !== '') ) {
            $query->where('post_id', '=', trim($params['post_id']));
        }
    }
}
