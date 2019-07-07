<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CommentsFormRequest;
use App\Comment;

class CommentsController extends Controller
{
    public function newComment(CommentsFormRequest $request)
    {
        $comment = new Comment(array(
            'post_id' => $request->get('post_id'),
            'content' => $request->get('content')
        ));

        $comment->save();

        return redirect()->back()->with('status', '¡Tu comentario ha sido creado!');
    }
}