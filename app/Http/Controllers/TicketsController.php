<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TicketsFormRequest;
use App\Ticket;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::all();//getAll tickets
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
       // return $request->all();
       $slug = uniqid();
       $ticket = new Ticket(array(
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'slug' => $slug,
            'user_id' => Auth::user()->id

       ));
       $ticket->save();

       $data = array(
        'ticket' => $slug,
         );

         Mail::send('emails.ticket', $data, function ($message) {
            $message->from('tutia@gmail.com', 'porque no lees los tickets');

            $message->to('martinnviqueira@gmail.com')->subject('¡Hay un nuevo ticket, leelo!');
         });

       return redirect('/contact')->with('status', 'Su ticket ha sido creado. Su id es: '.$slug);//devuelve a la vista status
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
    public function update($slug, TicketsFormRequest $request)
    {
      $ticket = Ticket::whereSlug($slug)->firstOrFail();
      $ticket->title = $request->get('title');
      $ticket->content = $request->get('content');
      if($request->get('status') != null) {
        $ticket->status = 0;
    } else {
        $ticket->status = 1;
     }
     $ticket->save();
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
     return redirect('/tickets')->with('status', 'El ticket '.$slug.' ha sido borrado');

     }
}
