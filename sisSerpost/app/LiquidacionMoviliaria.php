<?php

namespace sisSerpost;

use Illuminate\Database\Eloquent\Model;

class LiquidacionMoviliaria extends Model
{
    protected $table      = 'idliquidacion_moviliaria';
    protected $primaryKey = 'idliquidacion_moviliaria';
    public $timestamps    = false; //esto es el autocompletador

    //eston van hacer los campos que van hacer rellenables
    protected $fillable = [

        'idliquidacion_moviliaria',
        'idpersona',
        'fecha',
        'estado'      

    ];

    protected $guarded = [

    ];
}
