<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Ejercicio;

class AbmEjercicioController extends Controller
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
        if($api){
            $ejercicio = Ejercicio::filter($params)->get();
            return array("qty"=>count($ejercicio),"ejercicios"=>$ejercicio);
        }
        $ejercicio = Ejercicio::filter($params)->paginate(10);        
         return view('abmEjercicio.index',compact('ejercicio'))
             ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         //
         return view('abmEjercicio.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required'
        ]);

        $exist = Ejercicio::where('nombre',$request['nombre'])->first();

        if($exist){
            if($api){ 
                //return "Duplicate";
                return response()->json("Duplicate", 400);
            }else{
                $var = \Lang::get('parkinsoft.exerciseDuplicateMessageSuccessful');
                    return redirect()->route('abmEjercicio.index')
                        ->withSuccess($var);
            }
        }

        $ejercicio = Ejercicio::create([
            'nombre' => $request['nombre'],
            'descripcion' => $request['descripcion']
        ]);
        if($request->hasFile('audio_example')) {

            $file = $request->file('audio_example');
            
            if(!$file->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }
            if($file->getClientSize() > $file->getMaxFilesize()){
                return response()->json(['File_Too_Big'], 400);
            }
            $mime = $file->getClientMimeType();
            if(explode('/',$mime)[0] != 'audio'){
                return response()->json(['File_is_not_Audio'], 400);
            }
            $ejercicio = Ejercicio::findOrFail($ejercicio->id);
            $path = '/audio_example_ejercicios/';
            $name = $ejercicio->nombre;
            $extens= $file->getClientOriginalExtension();
            $file->move(storage_path('app').$path,$name.'.'.$extens);
            if($file->getClientOriginalExtension()!= 'mp3'){
                $this->ffmpeg($path.$name,$extens);
                Storage::disk('local')->delete($path.$name.'.'.$extens);
            }
            $ejercicio->audio_example_path = $path.$name.'.mp3';
            $ejercicio->save();
        }

        if($api){ return $ejercicio; }

        $var = \Lang::get('parkinsoft.exerciseNewMessageSuccessful');
        return redirect()->route('abmEjercicio.index')
                        ->withSuccess($var);

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ejercicio = Ejercicio::findOrFail($id);
        return view('abmEjercicio.show',compact('ejercicio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ejercicio = Ejercicio::findOrFail($id);
        return view('abmEjercicio.edit',compact('ejercicio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required'
        ]);

        $ejercicio = Ejercicio::findOrFail($id);

        $ejercicio->update($request->all());

        if($request->hasFile('audio_example')) {

            $file = $request->file('audio_example');
            
            if(!$file->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }
            if($file->getClientSize() > $file->getMaxFilesize()){
                return response()->json(['File_Too_Big'], 400);
            }
            $mime = $file->getClientMimeType();
            if(explode('/',$mime)[0] != 'audio'){
                return response()->json(['File_is_not_Audio'], 400);
            }
            $ejercicio = Ejercicio::findOrFail($ejercicio->id);
            $path = '/audio_example_ejercicios/';
            $name = $ejercicio->nombre;

            $extens= $file->getClientOriginalExtension();
            $file->move(storage_path('app').$path,$name.'.'.$extens);

            if($file->getClientOriginalExtension()!= 'mp3'){
                $this->ffmpeg($path.$name,$extens);

                Storage::disk('local')->delete($path.$name.'.'.$extens);
            }
            $ejercicio->audio_example_path = $path.$name.'.mp3';
            $ejercicio->save();
        }

        if($api) { return $ejercicio; }


        $var = \Lang::get('parkinsoft.exerciseUpdateMessageSuccessful');
        return redirect()->route('abmEjercicio.index')
                        ->withSuccess($var);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $api = substr ( $request->path(), 0,3 ) == 'api';
        $ejercicio = Ejercicio::where('id',$id)->first();
        
        $ejercicio->delete();

        if($api){ return 'ok'; }

        $var = \Lang::get('parkinsoft.exerciseDeleteMessageSuccessful');
        return redirect()->route('abmEjercicio.index')
                        ->withSuccess($var);
    }

    public function download_example($ejercicio_id)
    {
        $ejercicio = Ejercicio::findOrFail($ejercicio_id);
        if(!$ejercicio){
            return response()->json(['invalid_ejercicio'], 400);
        }

        $file= storage_path('app').'/'. $ejercicio->audio_example_path;

        $headers = array(
                'Content-Type: audio/mpeg',
                );

        if(Storage::disk('local')->exists($ejercicio->audio_example_path)){
            return response()->download($file, $ejercicio->nombre.'.mp3', $headers);
        }
        else{ 
            return redirect()->back()->withSuccess("No hay audio de Ejemplo para este Ejercicio");
        }
    }

    public function ffmpeg($name,$extens){

        $audioPath = storage_path('app').'/'.$name.'.'.$extens;
        $mp3Path = storage_path('app').'/'.$name.'.mp3';
        $exec = "/var/www/html/parkinsoft/scripts/ffmpeg.sh ".$audioPath ." ".$mp3Path;
        exec($exec);
        return $exec;
    }
}
