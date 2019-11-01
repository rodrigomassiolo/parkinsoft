<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TicketsFormRequest;
use App\Anotador;
use App\Comment;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
class AnotadorController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $anotador = Anotador::where('user_id',$user_id)->first();        
        if(!$anotador){
            $user = User::where('id',$user_id)->first();  
            $anotador = Anotador::create([
                'id'=>$user->id,
                'title'=>"Anotador de ".$user->usuario,
                'user_id'=>$user->id,
            ]);
        }
        $comments = Comment::filter(array('anotador_id' => $anotador->id))->get();
        return view('anotador.show', compact('anotador', 'comments'));
    }

    public function comment(Request $request){
        $comment = new Comment(array(
            'anotador_id' => $request->get('anotador_id'),
            'content' => $request->get('content'),
            'user_id' => Auth::user()->id
        ));

        $comment->save();

        return redirect()->back()->with('status', '¡Tu comentario ha sido creado!');
    }

}
