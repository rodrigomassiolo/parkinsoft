<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseDeDatosController extends Controller
{

  public function index(Request $request)
  {       
    $comando="/var/www/html/parkinsoft/scripts/showTables.sh";
    $tablas = null;
    exec($comando,$tablas);

    //TO-DO no tengo el showTables.sh 

    // $tablas=[];

    // $item1 = ['tabla' => 'users','id' => '1'];
    // $item2 = ['tabla' => 'operacion','id' => '2'];

    // array_push($tablas,$item1);
    // array_push($tablas,$item2);

    return view('baseDeDatos.index',compact('tablas'));
       // ->with('i', (request()->input('page', 1) - 1) * 10);
  }

    public function showTables()
    {
      $comando="/var/www/html/parkinsoft/scripts/showTables.sh";
      $tablas = null;
      exec($comando,$tablas);
      return $tablas;
    }

    public function showColumnsFromTable(Request $request)
    {
      $request->validate([
        'tabla' => 'required'
      ]);
      $tabla = $request->get('tabla');
      $comando="/var/www/html/parkinsoft/scripts/showColumnsFromTable.sh ".$tabla;
      exec($comando,$response);
      $result = array();
      for ($j=1; $j < count($response) ; $j++) {
        $row = str_getcsv ( $response[$j] , $delimiter = "\t" );
        $result[] = $row[0]; 
      }
      if($request->get('View')){
        // $test1 = 'nombreTest1';
        // $test2 = 'nombreTest2';
         $html = '';
        // $html .= '<tr><td>'. $test2 .'</td><td></td><td></td></tr>';
        foreach($result as $line){
          $html .= '<tr><td>'. $line .'</td><td></td><td></td></tr>';
        }
        return $html;
      }
      return $result;
    }

    public function getColumnSelect(Request $result){
      $request->validate([
        'tabla' => 'required'
      ]);
      $tabla = $request->get('tabla');
      $comando="/var/www/html/parkinsoft/scripts/showColumnsFromTable.sh ".$tabla;
      exec($comando,$response);
      $result = array();
      for ($j=1; $j < count($response) ; $j++) {
        $row = str_getcsv ( $response[$j] , $delimiter = "\t" );
        $result[] = ['id' => 0,'text' =>  $row[0]] ; 
      }
      $response = ['items' => $result];
      return $response;
    }

    public function showIndexesFromTable(Request $request)
    {
      $request->validate([
        'tabla' => 'required'
      ]);
      $tabla = $request->get('tabla');
      $comando="/var/www/html/parkinsoft/scripts/showIndexesFromTable.sh ".$tabla;
      exec($comando,$response);
      $result = array();
      for ($j=1; $j < count($response) ; $j++) {
        $row = str_getcsv ( $response[$j] , $delimiter = "\t" );
        $rowArray = array(
          "nombre_columna" =>  $row[4],
          "nombre_index" =>  $row[2]      
        );
        $result[] = $rowArray; 
      }

      if($request->get('View')){
        return $result;
      }

      return $result;
    }

    public function setIndex(Request $request)
    {
      $request->validate([
        'nombre_index' => 'required', 
        'tabla' => 'required',
        'columna' => 'required'        
      ]);
      $nombre_index = $request->get('nombre_index');
      $tabla = $request->get('tabla');
      $columna = $request->get('columna');
      $comando="/var/www/html/parkinsoft/scripts/setIndex.sh ".$nombre_index." ".$tabla." ".$columna;
      exec($comando,$response);
      return $response;
    }

    public function deleteIndex(Request $request)
    {
      $request->validate([
        'nombre_index' => 'required',
        'tabla' => 'required'        
      ]);
      $nombre_index = $request->get('nombre_index');
      $tabla = $request->get('tabla');
      $comando="/var/www/html/parkinsoft/scripts/deleteIndex.sh ".$nombre_index." ".$tabla;
      exec($comando,$response);
      return $response;
    }
}
