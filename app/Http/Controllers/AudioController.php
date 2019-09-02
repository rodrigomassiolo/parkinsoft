<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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

        // echo($request);

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
    
        $usr_folder = $request->user()->usuario;
        $path = public_path() . '/uploads/audios/'.$usr_folder.'/';
        $name = date("Ymd");
        $filename = $name.'.'.$extens;
        $file->move($path, $filename);

        if($extens != 'wav'){
            $this->ffmpeg($path,$name,$extens);
        }
        $this->openSmile("openSmileEnergy.sh",$path,$name);

        $user_id = $request->user()->id;
        $this->csvToDB("csvToDBEnergy.sh",$user_id,$path,$name);

        return "Ejecutando audio";
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

        //$audioPath = $path.$name.'.'.$extens;
        //$wavPath = $path.$name.'.wav';
        $audioPath ='/var/www/html/parkinsoft/public/uploads/audios/adhi456/20190902.wav';
        $wavPath    ='/var/www/html/parkinsoft/public/uploads/audios/adhi456/20190902.wav';
        $exec = "/var/www/html/parkinsoft/scripts/ffmpeg.sh ".$audioPath ." ".$wavPath;
        exec($exec);
        return $exec;
    }
    public function openSmile($openSmileScript,$path,$name){
        //$wavPath = $path.$name.'.wav';
        //$csvPath = $path.$name.'.csv';
        $openSmileScript = "openSmileEnergy.sh";
        $wavPath ='/var/www/html/parkinsoft/public/uploads/audios/adhi456/20190902.wav';
        $csvPath ='/var/www/html/parkinsoft/public/uploads/audios/adhi456/20190902.csv';
        $exec = "/var/www/html/parkinsoft/scripts/".$openSmileScript." ".$wavPath ." ".$csvPath;
        exec($exec);
        return $exec;
    }
    public function csvToDB($csvToDBScript,$user_id, $path,$name){
        //$csvpath = $path.$name.'.csv';
        $csvToDBScript = "csvToDBEnergy.sh";
        $user_id = 1;
        $csvPath ='/var/www/html/parkinsoft/public/uploads/audios/adhi456/20190902.csv';
        $exec = "/var/www/html/parkinsoft/scripts/".$csvToDBScript." ".$csvpath ." ".$user_id;
        exec($exec);
        return $exec;
    }
}
