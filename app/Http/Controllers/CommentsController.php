<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CommentsFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Comment;


class CommentsController extends Controller
{
    public function newComment(CommentsFormRequest $request)
    {
        $comment = new Comment(array(
            'post_id' => $request->get('post_id'),
            'content' => $request->get('content'),
            'user_id' => Auth::user()->id
        ));

        $comment->save();

        return redirect()->back()->with('status', '¡Tu comentario ha sido creado!');
    }
}