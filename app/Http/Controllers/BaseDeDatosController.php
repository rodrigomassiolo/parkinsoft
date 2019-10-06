<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseDeDatosController extends Controller
{
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
      exec($comando,$columns);
      $result = str_getcsv ( $columns , $delimiter = "\t" ); 
      return $result;
    }

    public function showIndexesFromTable(Request $request)
    {
      $request->validate([
        'tabla' => 'required'
      ]);
      $tabla = $request->get('tabla');
      $comando="/var/www/html/parkinsoft/scripts/showIndexesFromTable.sh ".$tabla;
      exec($comando,$indexes);
      return $indexes;
    }

    public function setIndex(Request $request)
    {
      $request->validate([
        'tabla' => 'required',
        'columna' => 'required'        
      ]);
      $tabla = $request->get('tabla');
      $columna = $request->get('columna');
      $comando="/var/www/html/parkinsoft/scripts/setIndex.sh ".$tabla." ".$columna;
      exec($comando,$response);
      return $response;
    }

    public function deleteIndex(Request $request)
    {
      $request->validate([
        'indexName' => 'required',
        'tabla' => 'required'        
      ]);
      $indexName = $request->get('indexName');
      $tabla = $request->get('tabla');
      $comando="/var/www/html/parkinsoft/scripts/deleteIndex.sh ".$indexName." ".$tabla;
      exec($comando,$response);
      return $response;
    }
}
