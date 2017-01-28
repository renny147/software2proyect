<?php

namespace sisSerpost;

use Illuminate\Database\Eloquent\Model;
use DB;

class EnvioEncomienda extends Model
{
    protected $table      = 'envio_encomienda';
    protected $primaryKey = 'idenvio_encomienda';
    public $timestamps    = false; //esto es el autocompletador

    //eston van hacer los campos que van hacer rellenables
    protected $fillable = [
        'idpersona',
        'tipo_comprobante',
        'fecha',
        'serie',
        'correlativo',
        'numero_boleta',
        'igv',

    ];

    protected $guarded = [

    ];


    public static function comprobanteFactura($tipo_comprobante)
    {
        if ($tipo_comprobante=='F') {
             return EnvioEncomienda::select('tipo_comprobante', DB::raw('LPAD(MAX(correlativo)+1,7,0) as correlativo'), DB::raw('LPAD(MAX(serie),4,0) as serie'))
                               ->where('tipo_comprobante','=',$tipo_comprobante)
                               ->groupBy('tipo_comprobante')
                               ->get();
        }else{
            if ($tipo_comprobante=='B') {
             return EnvioEncomienda::select('tipo_comprobante', DB::raw('LPAD(MAX(numero_boleta)+1,7,0) as numero_boleta'))
                               ->where('tipo_comprobante','=',$tipo_comprobante)
                               ->groupBy('tipo_comprobante')
                               ->get();
            }                 
        }
      
    }

    //CONCAT(LPAD(Vserie, 6, '0'), '-', LPAD(Vcorrelativo, 6, '0')) serial

}
