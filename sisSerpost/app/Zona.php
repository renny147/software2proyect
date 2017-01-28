<?php

namespace sisSerpost;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $table      = 'zona';
    protected $primaryKey = 'idzona';
    public $timestamps    = false;
    protected $fillable   = [
        'nombre',
        'descripcion',
        'iddepartamento_entrega',
        'idpeso',
        'tarifa',
        'fecha',
        'estado',

    ];

    protected $guarded = [

    ];

    public static function devolverTarifaZona($iddepartamento_entrega,$nombre_zona,$idpeso)
    {
        $zona=DB::table('zona')
                      ->select('idzona','tarifa')
                      //->join('departamento_entrega as ce','ce.iddepartamento_entrega','=',$iddepartamento_entrega)
                      //->join('peso as p','p.idpeso','=',$idpeso)
                      ->where('iddepartamento_entrega','=',$iddepartamento_entrega)
                      ->where('nombre','=',$nombre_zona)
                      ->where('idpeso','=',$idpeso)                    
                      ->get();
         return $zona;         

    } 

    public static function tarifaZona(Request $request){
    $data = $request->all();
    $destino= $data['pdestino'];
    $zona= $data['pzona'];
    $peso= $data['pidpeso'];

   $zona=DB::table('zona')
                      ->select('idzona','tarifa')
                      //->join('departamento_entrega as ce','ce.iddepartamento_entrega','=',$iddepartamento_entrega)
                      //->join('peso as p','p.idpeso','=',$idpeso)
                      ->where('iddepartamento_entrega','=',$destino)
                      ->where('nombre','=',$zona)
                      ->where('idpeso','=',$peso)                    
                      ->get();
         return $zona;  
    }


}
