<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Ejercicio;
use App\PacienteEjercicio;

class AudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('audio.index');
    }

    public function indexLevodopa(Request $request)
    {
        return view('audio.indexLevodopa');
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

        if(!$request->hasFile('audio')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $file = $request->file('audio');
        
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
        $extens= $file->getClientOriginalExtension();
        if($file->getClientOriginalExtension()== 'mp3'){
            return response()->json(['NO_mp3'], 400);
        }
        
        $ejercicio_id= 1;
        $ejercicio_nombre= 'a';
        if($request->has('ejercicio')){
            $ejercicio = Ejercicio::findOrFail($request->input('ejercicio'));
            $ejercicio_id=$ejercicio->id;
            $ejercicio_nombre=$ejercicio->nombre;
        }

        if($request->has('user')){
            $user = User::findOrFail($request->input('user'));
        }
        else{
            $user = $request->user();
        }

        $path = storage_path('app').'/resultados/'.$user->usuario.'/';
        $name = date("Ymd").$ejercicio_nombre;//hasta un ejercicio del mismo tipo por dia, si lo hace devuelta reemplaza
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
        
        PacienteEjercicio::create([
            'user_id' => $user->id,
            'ejercicio_id' => $ejercicio_id,
            'audio_path' => '/resultados/'.$user->usuario.'/',
            'audio_name' => $name,
            'audio_ext' =>$extens 
        ]);
        
        return "ok";
    }
    public function storeLevodopa(Request $request)
    {
        if(!$request->hasFile('audio1')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $file1 = $request->file('audio1');
        
        if(!$file1->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        if($file1->getClientSize() > $file1->getMaxFilesize()){
            return response()->json(['File_Too_Big'], 400);
        }
        $mime = $file1->getClientMimeType();
        if(explode('/',$mime)[0] != 'audio'){
            return response()->json(['File_is_not_Audio'], 400);
        }
        $extens= $file1->getClientOriginalExtension();
        if($file1->getClientOriginalExtension()== 'mp3'){
            return response()->json(['NO_mp3'], 400);
        }

        if(!$request->hasFile('audio2')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $file2 = $request->file('audio2');
        
        if(!$file2->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        if($file2->getClientSize() > $file2->getMaxFilesize()){
            return response()->json(['File_Too_Big'], 400);
        }
        $mime = $file2->getClientMimeType();
        if(explode('/',$mime)[0] != 'audio'){
            return response()->json(['File_is_not_Audio'], 400);
        }
        $extens= $file2->getClientOriginalExtension();
        if($file2->getClientOriginalExtension()== 'mp3'){
            return response()->json(['NO_mp3'], 400);
        }

    
        $usr_folder = $request->user()->usuario;
        $path = public_path() . '/uploads/audios/'.$usr_folder.'/levodopa/';
        $file1->move($path, date("Ymd").'_1.'.$extens);
        $file2->move($path, date("Ymd").'_2.'.$extens);
        return "Ejecutando audios";
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
    public function processAudio(Request $request){

        $pacienteEjercicio = PacienteEjercicio::findOrFail($request->input('pacienteEjercicio'));
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
            if(Storage::disk('local')->exists($path.$name.".wav")){
                $pacienteEjercicio->audio_ext = 'wav';
                $pacienteEjercicio->save();
            }
            else{
                return "Error en ffmpeg";
            }
        }

        $energy = 0;
        if($request->input('Energy') == "1"){
            $energy = 1;
            $this->openSmile("openSmileEnergy",$absPath,$name);
            $this->csvToDB("csvToDBEnergy.sh","openSmileEnergy",$user_id,$absPath,$name,$pacienteEjercicio->id);
        }
        
        $eGemaps = 0;
        if($request->input('eGemaps')== "1"){
            $eGemaps = 1;
            $this->openSmile("openSmileEGMaps",$absPath,$name);
            $this->csvToDB("csvToDBEGMaps.sh","openSmileEGMaps",$user_id,$absPath,$name,$pacienteEjercicio->id);
        }

        $chroma = 0;
        if($request->input('Chroma')== "1"){
            $chroma = 1;
            $this->openSmile("openSmileChroma",$absPath,$name);
            $this->csvToDB("csvToDBChroma.sh","openSmileChroma",$user_id,$absPath,$name,$pacienteEjercicio->id);
        }

        $audspec= 0;
        if($request->input('Audspec')== "1"){
            $audspec = 1;
            $this->openSmile("openSmileAudspec",$absPath,$name);
            $this->csvToDB("csvToDBAudspec.sh","openSmileAudspec",$user_id,$absPath,$name,$pacienteEjercicio->id);
        }

        $prosody = 0;
        if($request->input('Prosody')== "1"){
            $prosody = 1;
            $this->openSmile("openSmileProsodyAcf",$absPath,$name);        
            $this->csvToDB("csvToDBProsodyAcf.sh","openSmileProsodyAcf",$user_id,$absPath,$name,$pacienteEjercicio->id);
        }

        
        if($request->input('output')== "html"){
            $this->plotRmd('html_document', $absPath.$name.".html",$pacienteEjercicio->id,$energy,$eGemaps,$chroma,$audspec,$prosody);
            if($request->input('Download')== "1"){
                return response()->download($absPath.$name.'.html');                
            }
            if($request->input('View')== "1"){
            $response = Storage::disk('local')->get($path.$name.".html");
            return View('audio.graphic')->with('data',$response);
            }
        }
        if($request->input('output')== "pdf"){
            $this->plotRmd('pdf_document', $absPath.$name.".pdf",$pacienteEjercicio->id,$energy,$eGemaps,$chroma,$audspec,$prosody);
            return response()->download($absPath.$name.'.pdf');
        }
        
    }

    public function plotRmd($tipoSalida, $pathsalida,$pacienteEjercicio, $energy,$eGemaps,$chroma,$audspec,$prosody){
        $scriptR = "/var/www/html/parkinsoft/scripts/knit.R";
        $scriptRMD = "/var/www/html/parkinsoft/scripts/plot.Rmd";
        $exec = "Rscript ".$scriptR." ".$scriptRMD." ".$tipoSalida ." ".$pathsalida." ".$pacienteEjercicio." ".$energy." ".$eGemaps." ".$chroma." ".$audspec." ".$prosody;
        exec($exec);
        return $exec;
    }
}
