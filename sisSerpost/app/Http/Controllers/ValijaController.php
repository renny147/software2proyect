<?php

namespace sisSerpost\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use sisSerpost\Http\Requests\ValijaRequest;
use sisSerpost\Valija;
use sisSerpost\EnvioEncomienda;
use sisSerpost\Http\Requests\EnvioEncomiendaRequest;

class ValijaController extends Controller
{
     public function __construct()
   {
        $this->middleware('auth');
   }

    public function index(Request $request)
    {
        if ($request) {
            $query   = trim($request->get('searchText'));
            $valijas = DB::table('valija')
            ->where('idvalija', 'LIKE', $query . '%')
            ->orderBy('idvalija', 'asc')->paginate(7);
            
            return view('envio.valija.index', ["valijas" => $valijas, "searchText" => $query]);
        }

    }

    public function create()
    {

        return view("envio.valija.create");

    }

    public function store(ValijaRequest $request)
    {
        $valija              = new Valija;
        $valija->descripcion = $request->get('descripcion');
        $valija->save();
        return Redirect::to('envio/valija');

    }

    public function show($idvalija)
    {
         $valija = DB::table('valija')
            ->select('idvalija')
            ->where('idvalija', '=', $idvalija) 
             ->first();//esto es importante


         $detalles = DB::table('detalle_valija as dv')
            ->join('envio_encomienda as ec','ec.idenvio_encomienda','dv.idenvio_encomienda')   
            ->join('departamento_entrega as ce', 'ce.iddepartamento_entrega', '=', 'dv.iddepartamento_entrega')
            ->join('persona as p','p.idpersona','=','ec.idpersona')
            ->join('ciudad as c', 'c.idciudad', '=', 'ce.origen')
            ->join('ciudad as ci', 'ci.idciudad', '=', 'ce.destino')
            
            ->select('ec.idenvio_encomienda','c.nombre as origen', 'ci.nombre as destino',DB::raw('CONCAT(p.nombre," ",p.apell_paterno," ",p.apell_materno) as cliente'))
            ->where('dv.idvalija', '=', $idvalija)
            //->groupBy('ec.idenvio_encomienda','c.nombre as origen', 'ci.nombre as destino') 
            ->get();

        return view("envio.valija.show", ["valija" => $valija, "detalles" => $detalles]);

    }

    public function edit($idvalija)
    {
        return view("envio.valija.edit", ["valija" => Valija::findOrFail($idvalija)]);
    }

    public function update(ValijaRequest $request, $idvalija)
    {
        $valija              = Valija::findOrFail($idvalija);
        $valija->descripcion = $request->get('descripcion'); //(como se llama el objeto de validacion)
        $valija->update();
        return Redirect::to('envio/valija');

    }
    public function destroy($idciudad)
    {
        $valija = Valija::findOrFail($idvalija);
        $valija->delete();
        return Redirect::to('envio/valija');
    }
}
