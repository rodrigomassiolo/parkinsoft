<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TicketsFormRequest;
use App\Ticket;
use App\Comment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $params = $request->except('_token');
        session()->flashInput($request->input());
        $tickets = Ticket::filter($params)->get();
        if($api){
           return array("qty"=>count($tickets),"ejercicios"=>$tickets);
        }

        return view('tickets.index', compact('tickets'));//envio todos los tickets en un array a la vista
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketsFormRequest $request)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $email;
        
        if($request->get('email')){
            $email = $request->get('email');
        }else{
            Auth::user()->email;
        }

       $slug = uniqid();
       $ticket = new Ticket(array(
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'slug' => $slug,
            'user_id' => Auth::user()->id,
            'email' => $email
       ));
       $ticket->save();

       if($api){ return $ticket; }
       $data = array(
        'ticket' => $slug,
         );

         Mail::send('emails.ticket', $data, function ($message) {
            $message->from('admin@higia.com', 'Nuevo ticket');
            //Hay que poner el mail de admin higia
            
            //Hay que poner el usuario
            $message->to('martinnviqueira@gmail.com')->subject('¡Hay un nuevo ticket, leelo!');
         });

       return redirect()->back()->with('status', 'Su ticket ha sido creado.');//devuelve a la vista status
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();//primer resultado o except
        $comments = $ticket->comments()->get();
        return view('tickets.show', compact('ticket', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $requests
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($slug,Request $request)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        if($api) {     
            $request->validate([
                'content' => 'required'
            ]); 
            $ticket = Ticket::whereSlug($slug)->firstOrFail();
        }
        else{
            $ticket = Ticket::whereSlug($slug)->firstOrFail();
        }
        if($request->get('status') != null) {
        $ticket->status = 0;
        } 
        else {
        $ticket->status = 1;
        }  

        $comment = new Comment(array(
            'post_id' => $ticket->id,
            'content' => $request->get('content'),
            'user_id' => Auth::user()->id
        ));

        $comment->save();
        $ticket->save();
        if($api) {
            $params = array(
                "post_id"=>$ticket->id
            );
            $comments = Comment::filter($params)->get();
            $ticket->comments = $comments;
        }
        
        if($ticket->status == 1){
            $data = array(
               'response' => $comment->content,
                );
            Mail::send('emails.ticketResponse', $data, function ($message) {
                $message->from('admin@higia.com', 'Nuevo ticket');
                //Hay que poner el mail de admin higia

                //Hay que poner el usuario
                $message->to('martinnviqueira@gmail.com')->subject('Consulta Parkinsoft');
            });
            if($api) { return "cerrado"; }
            return redirect(action('TicketsController@edit', $ticket->slug))->with('status', 'Se ha enviado un email al usuario con la respuesta');
        }
        if($api) {
            return $ticket;
        }
     return redirect(action('TicketsController@edit', $ticket->slug))->with('status', '¡El ticket '.$slug.' ha sido actualizado!');

     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
     $ticket = Ticket::whereSlug($slug)->firstOrFail();
     $ticket->delete();
     return redirect()->back()->with('status', 'El ticket '.$slug.' ha sido borrado');

     }
}
