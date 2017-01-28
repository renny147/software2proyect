<?php

namespace sisSerpost;

use Illuminate\Database\Eloquent\Model;

class SubTipoCorrespondencia extends Model
{
    protected $table      = 'sub_tipo_correspondencia';
    protected $primaryKey = 'idsub_tipo_correspondencia';

    public $timestamps = false; //esto es el autocompletador

    //eston van hacer los campos que van hacer rellenables
    protected $fillable = [
        'idsub_tipo_correspondencia',
        'nombre',
        'descripcion',
    ];

    protected $guarded = [

    ];

    //esto es un funcion estatica el cual le pasamos el id tipo de correspondencia
    public static function subCorrespondencias($id)
    {
        return SubTipoCorrespondencia::where('idtipo_correspondencia', '=', $id)
            ->get();
    }

}
