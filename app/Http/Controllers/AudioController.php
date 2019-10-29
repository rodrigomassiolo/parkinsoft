<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Auth\RegisterController;
use App\User;
use App\Ejercicio;
use App\PacienteEjercicio;
use App\Rol;
use Lang;

class AudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        $preset = null;
        if($request->get('user_id') != null){
            $preset = $request->get('user_id');
        }else{
            $preset = -1;
        }

        $user = Auth::user()->usuario;
        $rol_id = Auth::user()->rol_id;
        $rol = Rol::where('id', $rol_id)->get();

        

        if($rol[0]->type == 0 || $rol[0]->type == 1){

            $pacientes = User::whereHas('rol',function($q){
                $q->where('type','=',2);
            })->get();
            $params = array('status' => 'realizado', 'deleted_at' => null);
            
        }
        else{
             $pacientes = null;
             $params = array('status' => 'realizado','usuario' => $user,'deleted_at' => null);
        }

        $PacienteEjercicio = PacienteEjercicio::filter($params)->orderBy('created_at', 'desc')->paginate(10);


        $ejercicio = Ejercicio::all();

        return view('audio.index',compact('PacienteEjercicio','ejercicio','pacientes','preset'))
            ->with('i', (request()->input('page', 1) - 1) * 10);

    }

    public function indexS(){
        return view('audio.index')->with('success','Audio cargado correctamente');
    }
    
    public function indexLevodopa(){

        $user = Auth::user()->usuario;
        $rol_id = Auth::user()->rol_id;
        $rol = Rol::where('id', $rol_id)->get();

        if($rol[0]->type == 0 || $rol[0]->type == 1){

            $pacientes = User::whereHas('rol',function($q){
                $q->where('type','=',2);
            })->get();
        }

        $params = array('usuario' => $user, 'deleted_at' => null);

        $PacienteEjercicio = PacienteEjercicio::filter($params)->paginate(10);

        $mode = 0;

        $results = collect([]);
        return view('audio.indexLevodopa',compact('PacienteEjercicio','pacientes','mode','results'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        if(!$request->hasFile('audio')) {
            if($request->has('View')){
                $var = \Lang::get('parkinsoft.audioUploadFileNotFound');
                return redirect()->route('audio')->withSuccess($var);
            }
            return response()->json(['upload_file_not_found'], 400);
        }
        $file = $request->file('audio');
        
        if(!$file->isValid()) {
            if($request->has('View')){
                $var = \Lang::get('parkinsoft.audioInvalidFileUpload');
                return redirect()->route('audio')->withSuccess($var);
            }
            return response()->json(['invalid_file_upload'], 400);
        }
        if($file->getClientSize() > $file->getMaxFilesize()){
            if($request->has('View')){
                $var = \Lang::get('parkinsoft.audioFileTooBig');
                return redirect()->route('audio')->withSuccess($var);
            }
            return response()->json(['File_Too_Big'], 400);
        }
        $mime = $file->getClientMimeType();
        if(explode('/',$mime)[0] != 'audio'){
            if($request->has('View')){
                $var = \Lang::get('parkinsoft.audioFileIsNotAudio');
                return redirect()->route('audio')->withSuccess($var);
            }
            return response()->json(['File_is_not_Audio'], 400);
        }
        $extens= $file->getClientOriginalExtension();
        if($file->getClientOriginalExtension()== 'mp3'){
            if($request->has('View')){
                $var = \Lang::get('parkinsoft.audioNoMp3');
                return redirect()->route('audio')->withSuccess($var);
            }
            return response()->json(['NO_mp3'], 400);
        }

        $ejercicio_id= 1;
        $ejercicio_nombre= 'a';

        if($request->has('ejercicio')){
            $id_ejercicio= $request->input('ejercicio');
            $ejercicio = Ejercicio::where('id',$id_ejercicio)->first();
            if(!$ejercicio){
                if($request->has('View')){
                    $var = \Lang::get('parkinsoft.audioInvalidExercise');
                    return redirect()->route('audio')->withSuccess($var);
                }
                return response()->json(['invalid_ejercicio'], 400);
            }
            $ejercicio_id=$ejercicio->id;
            $ejercicio_nombre=$ejercicio->nombre;
        }
        
        if($request->has('user')){
            $user = User::findOrFail($request->input('user'));
        }
        else{
            $user = $request->user();
        }

        if($request->has('ultimaMedicacion')){
            $ultimaMedicacion = $request->input('ultimaMedicacion');
        }
        else{
            $ultimaMedicacion = "";
        }

        if($api){
            $origen_audio = "celular";
        }
        if($request->has('origen_audio')){
            $origen_audio = $request->input('origen_audio');
        }
        else{
            $origen_audio = "";
        }

        $path = storage_path('app').'/resultados/'.$user->usuario.'/';
        $name = date("Ymd").$ejercicio_nombre;//hasta un ejercicio del mismo tipo por dia, si lo hace devuelta reemplaza

        if($request->has('es_levodopa') 
            &&  $request->input('es_levodopa') == 1
            && $request->has('modo_levodopa')
            &&  $request->input('modo_levodopa')!= null 
            ){
            $name = $request->input('modo_levodopa').'_'.$name;
            $es_levodopa = $request->input('es_levodopa');
            $modo_levodopa = $request->input('modo_levodopa');
        }else {
            $es_levodopa = null;
            $modo_levodopa = null;
        }

        $filename = $name.'.'.$extens;
        
        $pacEjer = PacienteEjercicio::where([
            ['user_id', '=', $user->id],
            ['audio_name', '=', $name],
        ])->get();

        if (count($pacEjer) != 0)
        {
            foreach ($pacEjer as $key => $pe) {
                $comando="/var/www/html/parkinsoft/scripts/clearTables.sh ".$pe->id;
                exec($comando);
                $pe->delete();
            }
            $comando="/var/www/html/parkinsoft/scripts/clearFiles.sh '".$path.$name."*'";
            exec($comando);
        }

        $file->move($path, $filename);

        if(!$request->has('paciente_ejercicio')) {
            PacienteEjercicio::create([
                'user_id' => $user->id,
                'ejercicio_id' => $ejercicio_id,
                'audio_path' => '/resultados/'.$user->usuario.'/',
                'audio_name' => $name,
                'audio_ext' =>$extens,
                'ultimaMedicacion' => $ultimaMedicacion,
                'es_levodopa' => $es_levodopa,
                'modo_levodopa' => $modo_levodopa,
                'origen_audio' => $origen_audio,
                'status'=>"realizado"
            ]);
        }
        else{
            $ejercicioAsignado = PacienteEjercicio::findOrFail($request->input('paciente_ejercicio'));
            $ejercicioAsignado->audio_path = '/resultados/'.$user->usuario.'/';
            $ejercicioAsignado->audio_name = $name;
            $ejercicioAsignado->audio_ext = $extens;
            $ejercicioAsignado->ultimaMedicacion = $ultimaMedicacion;
            $ejercicioAsignado->origen_audio = $origen_audio;
            $ejercicioAsignado->status = "realizado";
            $ejercicioAsignado->save();
        }

        if($request->has('View')){
            $var = \Lang::get('parkinsoft.audioUploadCorrectly');
                    return redirect()->route('audio')->withSuccess($var);
           // return redirect()->route('audio')->withSuccess('Audio cargado correctamente');
        }
        if($request->has('Realizado')){
            $var = \Lang::get('parkinsoft.exerciseCompletedCorrectly');
                    return redirect()->route('listaDeEjerciciosAsignados')->withSuccess($var);
           // return redirect()->route('audio')->withSuccess('Audio cargado correctamente');
        }
        if($request->has('Levodopa')){
            $var = \Lang::get('parkinsoft.audioUploadCorrectly');
                    return redirect()->route('audio')->withSuccess($var);
           // return redirect()->route('TestLevodopa')->withSuccess('Audio cargado correctamente');
        }
        
        // if($request->has('View'))
        // {
        //     return View('audio.index')->with('success','Audio cargado correctamente');
        // }

        return "ok";
    }
    public function graphic(){
        $response = Storage::disk('local')->get('pepe.html');
        
        return View('audio.graphic')->with('data',$response);
    }
    public function ffmpeg($path,$name,$extens){

        $audioPath = $path.$name.'.'.$extens;
        $wavPath = $path.$name.'.wav';
        $exec = "/var/www/html/parkinsoft/scripts/ffmpeg.sh ".$audioPath ." ".$wavPath;
        exec($exec);
        return $exec;
    }
    public function openSmile($openSmileScript,$path,$name){
        $wavPath = $path.$name.'.wav';
        $csvPath = $path.$name.$openSmileScript.'.csv';
       //$openSmileScript = "openSmileEnergy";
        $exec = "/var/www/html/parkinsoft/scripts/".$openSmileScript.".sh ".$wavPath ." ".$csvPath;
        exec($exec);
        return $exec;
    }
    public function csvToDB($csvToDBScript,$openSmileScript,$user_id, $path,$name,$ejerciciopaciente_id){
        $csvPath = $path.$name.$openSmileScript.'.csv';
        //$csvToDBScript = "csvToDBEnergy.sh";
        $exec = "/var/www/html/parkinsoft/scripts/".$csvToDBScript." ".$csvPath ." ".$user_id." ".$ejerciciopaciente_id;
        exec($exec);
        return $exec;
    }

    public function prepareAudios($audioName,$energy,$eGemaps,$chroma,$audspec,$prosody){
        $pacienteEjercicio = PacienteEjercicio::findOrFail($audioName);
        $user = User::findOrFail($pacienteEjercicio->user_id);
        $user_id = $user->id;
        $name = $pacienteEjercicio->audio_name;
        $extens = $pacienteEjercicio->audio_ext;
        $path = $pacienteEjercicio->audio_path;
        $absPath = storage_path('app').$path;


        $pacEjer = PacienteEjercicio::where([
            ['user_id', '=', $user->id],
            ['audio_name', '=', $name],
        ])->get();
    
        if (count($pacEjer) != 0)
        {
            foreach ($pacEjer as $key => $pe) {
                $comando="/var/www/html/parkinsoft/scripts/clearTables.sh ".$pe->id;
                exec($comando);
            }
            $comando="/var/www/html/parkinsoft/scripts/clearFiles.sh '".$absPath.$name."*.csv'";
            exec($comando);
            $comando="/var/www/html/parkinsoft/scripts/clearFiles.sh '".$absPath.$name."*.html'";
            exec($comando);
            $comando="/var/www/html/parkinsoft/scripts/clearFiles.sh '".$absPath.$name."*.pdf'";
            exec($comando);
        }

        if($extens != 'wav'){
            $this->ffmpeg($absPath,$name,$extens);
            $comando="/var/www/html/parkinsoft/scripts/clearFiles.sh '".$absPath.$name."*.".$extens."'";
            exec($comando);
            if(Storage::disk('local')->exists($path.$name.".wav")){
                $pacienteEjercicio->audio_ext = 'wav';
                $pacienteEjercicio->save();
            }
            else{
                return "Error en ffmpeg";
            }
        }

        if($energy){
            $this->openSmile("openSmileEnergy",$absPath,$name);
            $this->csvToDB("csvToDBEnergy.sh","openSmileEnergy",$user_id,$absPath,$name,$pacienteEjercicio->id);
        }

        if($eGemaps){
            $this->openSmile("openSmileEGMaps",$absPath,$name);
            $this->csvToDB("csvToDBEGMaps.sh","openSmileEGMaps",$user_id,$absPath,$name,$pacienteEjercicio->id);
        }

        if($chroma){
            $this->openSmile("openSmileChroma",$absPath,$name);
            $this->csvToDB("csvToDBChroma.sh","openSmileChroma",$user_id,$absPath,$name,$pacienteEjercicio->id);
        }

        if($audspec){
            $this->openSmile("openSmileAudspec",$absPath,$name);
            $this->csvToDB("csvToDBAudspec.sh","openSmileAudspec",$user_id,$absPath,$name,$pacienteEjercicio->id);
        }

        if($prosody){
            $this->openSmile("openSmileProsodyAcf",$absPath,$name);        
            $this->csvToDB("csvToDBProsodyAcf.sh","openSmileProsodyAcf",$user_id,$absPath,$name,$pacienteEjercicio->id);
        }
        return $name;
    }

    public function processAudio(Request $request){

        $energy = 0;
        if($request->input('Energy') == "1"){
            $energy = 1;
        }
        
        $eGemaps = 0;
        if($request->input('eGemaps')== "1"){
            $eGemaps = 1;
        }

        $chroma = 0;
        if($request->input('Chroma')== "1"){
            $chroma = 1;
        }

        $audspec= 0;
        if($request->input('Audspec')== "1"){
            $audspec = 1;
        }

        $prosody = 0;
        if($request->input('Prosody')== "1"){
            $prosody = 1;
        }    
        $name = "";
        $ejercicios = "(";    
        if($request->exists('pacienteEjercicio') && $request->input('pacienteEjercicio') != ""){
            $paej = $request->input('pacienteEjercicio');
            $name = $this->prepareAudios($paej,$energy,$eGemaps,$chroma,$audspec,$prosody);
            $ejercicios = $ejercicios.$paej;        
        }else{        
            return "Error falta pacienteEjercicio";
        }
        if($request->exists('CompareAudio1') && $request->input('CompareAudio1') != ""){
            $paej = $request->input('CompareAudio1');
            $prep = $this->prepareAudios($paej,$energy,$eGemaps,$chroma,$audspec,$prosody);
            $name = $name.'_'.$prep;
            $ejercicios = $ejercicios.",".$paej;        
        }
        if($request->exists('CompareAudio2') && $request->input('CompareAudio2') != ""){
            $paej = $request->input('CompareAudio2');
            $prep = $this->prepareAudios($paej,$energy,$eGemaps,$chroma,$audspec,$prosody);
            $name = $name.'_'.$prep;
            $ejercicios = $ejercicios.",".$paej;        
        }
        $ejercicios = $ejercicios.")";    
        $pacienteEjercicio = PacienteEjercicio::findOrFail($request->input('pacienteEjercicio'));    
        $path = $pacienteEjercicio->audio_path;
        $absPath = storage_path('app').$path;
        if($request->input('output')== "html"){
            $this->plotRmd('html_document', $absPath.$name.".html",$ejercicios,$energy,$eGemaps,$chroma,$audspec,$prosody);
            if($request->input('Download')== "1"){
                return response()->download($absPath.$name.'.html');                
            }
            if($request->input('View')== "1"){
            $response = Storage::disk('local')->get($path.$name.".html");
            return View('audio.graphic')->with('data',$response);
            }
        }
        if($request->input('output')== "pdf"){
            $this->plotRmd('pdf_document', $absPath.$name.".pdf",$ejercicios,$energy,$eGemaps,$chroma,$audspec,$prosody);
            return response()->download($absPath.$name.'.pdf');
        }
        $var = \Lang::get('parkinsoft.oneConfiguration');
        return redirect()->back()->withSuccess($var);
    }

    public function plotRmd($tipoSalida, $pathsalida,$ejercicios, $energy,$eGemaps,$chroma,$audspec,$prosody){    
        $scriptR = "/var/www/html/parkinsoft/scripts/knit.R";
        $scriptRMD = "/var/www/html/parkinsoft/scripts/plot.Rmd";
        $exec = "Rscript ".$scriptR." ".$scriptRMD." ".$tipoSalida ." ".$pathsalida." '".$ejercicios."' ".$energy." ".$eGemaps." ".$chroma." ".$audspec." ".$prosody;    
        exec($exec);    
        return $exec;
    }
}
