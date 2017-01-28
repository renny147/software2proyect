<?php

namespace sisSerpost\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use sisSerpost\DetalleEnvioEncomienda;
use sisSerpost\EnvioEncomienda;
use sisSerpost\Http\Requests\EnvioEncomiendaRequest;

class EnvioEncomiendaController extends Controller
{
        public function __construct()
   {
        $this->middleware('auth');
   }
 
    public function index(Request $request)
    {
        if ($request) {
            $query  = trim($request->get('searchText'));
            $envios = DB::table('envio_encomienda as ec')
                ->join('persona as p', 'p.idpersona', '=', 'ec.idpersona')
                ->join('detalle_envio_encomienda as de', 'de.idenvio_encomienda', '=', 'ec.idenvio_encomienda')
                ->join('zona as z', 'z.idzona', '=', 'de.idzona')
                ->select('ec.idenvio_encomienda', 'ec.fecha', 'p.nombre', 'p.apell_paterno', 'p.apell_materno', 'de.consignado', 'ec.tipo_comprobante', 'ec.serie', 'ec.correlativo', 'ec.igv', 'z.tarifa', 'de.cantidad', DB::raw('SUM(de.cantidad*z.tarifa) as total'))
                ->where('ec.correlativo', 'LIKE', '%' . $query . '%')
                ->orderBy('ec.idenvio_encomienda', 'desc')
                ->groupBy('ec.idenvio_encomienda', 'ec.fecha', 'p.nombre', 'p.apell_paterno', 'p.apell_materno', 'de.consignado', 'ec.tipo_comprobante', 'ec.serie', 'ec.correlativo', 'ec.igv', 'z.tarifa', 'de.cantidad')
                ->paginate(7);

            return view('envio.envioEncomienda.index', ["envios" => $envios, "searchText" => $query]);}

    }

    public function create(Request $request)
    {
        $personas = DB::table('persona as p')
            ->select('p.idpersona', DB::raw('CONCAT(p.nombre," ",p.apell_paterno," ",p.apell_materno) as cliente'))
            ->where('p.tipo', '=', 'Cliente')
            ->orderBy('p.nombre','asc')
            ->get();

        $zonas = DB::table('zona as z')
            ->join('departamento_entrega as ce', 'ce.iddepartamento_entrega', '=', 'z.iddepartamento_entrega')
            ->join('departamento as c', 'c.iddepartamento', '=', 'ce.origen')
            ->join('departamento as cc', 'cc.iddepartamento', '=', 'ce.destino')
            ->select('z.idzona', 'z.nombre', 'c.nombre as origen', 'cc.nombre as destino')
            ->get();

        $tipo_correspondencias = DB::table('tipo_correspondencia')
            ->get();

        $sub_tipo_correspondencias = DB::table('sub_tipo_correspondencia as stp') //->get();
            ->join('tipo_correspondencia as tp', 'tp.idtipo_correspondencia', '=', 'stp.idtipo_correspondencia')
            ->select('stp.idsub_tipo_correspondencia', 'tp.nombre as tp_nombre', 'stp.nombre')
            ->orderBy('tp.nombre', 'asc')
            ->get();

        $pesos = DB::table('peso')
            ->where('estado', '=', '1')
            ->get();

        $departamentos_origen = DB::table('departamento_entrega as ce')
            ->select('ce.origen','c.nombre','ce.iddepartamento_entrega')
            ->distinct()
            ->join('departamento as c', 'c.iddepartamento', '=', 'ce.origen')
            ->groupBy('ce.iddepartamento_entrega','c.nombre')
            ->orderBy('c.nombre')
            ->get();

        return view("envio.envioEncomienda.create", ["personas" => $personas, "zonas" => $zonas, "tipo_correspondencias" => $tipo_correspondencias, "sub_tipo_correspondencias" => $sub_tipo_correspondencias, "pesos" => $pesos, "departamentos_origen" => $departamentos_origen]);

    }

    public function store(EnvioEncomiendaRequest $request)
    {
      //  try {
            
            DB::beginTransaction();
            $envio_encomienda                   = new EnvioEncomienda;
            $envio_encomienda->idpersona        = $request->get('pidpersona');
            $envio_encomienda->tipo_comprobante = $request->get('ptipo_comprobante');
            $envio_encomienda->serie            = $request->get('pserie');
            $envio_encomienda->correlativo      = $request->get('pcorrelativo');
            $mytime                             = Carbon::now('America/Lima');
            $envio_encomienda->fecha            = $mytime->toDateTimeString();
            $envio_encomienda->igv              = '18';

         //   DB::INSERT("call insertarNuevaEncomiendaEnvio("$idpersona","$tipo_comprobante","$serie","$correlativo","$fecha","$igv")");

            $envio_encomienda->save();

            $idsub_tipo_correspondencia = $request->get('pidsub_tipo_correspondencia');
            $consignado             = $request->get('pconsignado');
            $idzona=15;                 
            //$request->get('idzona');
            $cantidad               = $request->get('pcantidad');
            $descripcion            = $request->get('pdescripcion');
            $total                  = $request->get('ptotal');
            $estado                 = $request->get('pestado');

            $cont = 0;
            while ($cont <= count($idsub_tipo_correspondencia)) {
                $detalle                         = new DetalleEnvioEncomienda();
                $detalle->idenvio_encomienda     = $envio_encomienda->idenvio_encomienda;
                $detalle->idsub_tipo_correspondencia = $idsub_tipo_correspondencia[$cont];
                $detalle->consignado             = $consignado[$cont];
                $detalle->idzona                 = $idzona[$cont];
                $detalle->cantidad               = $cantidad[$cont];
                $detalle->descripcion            = $descripcion[$cont];
                $detalle->total                  = $total[$cont];
                $detalle->estado                 = $estado[$cont];
                $detalle->save();
                $cont = $cont + 1;

            }

            DB::commit();

       // } catch (\Exception $e) {
       //     DB::rollback();
       // }
        return Redirect::to('envio/envioEncomienda');
    }


    public function show($idenvio_encomienda)
    {
        $envio_encomienda = DB::table('envio_encomienda as ec')

            ->join('persona as p', 'ec.idpersona', '=', 'p.idpersona')
            ->join('detalle_envio_encomienda as de', 'ec.idenvio_encomienda', '=', 'de.idenvio_encomienda')
            ->join('zona as z', 'z.idzona', '=', 'de.idzona')


            ->select('ec.idenvio_encomienda', 'ec.fecha', 'p.nombre as nombre_cliente', 'ec.tipo_comprobante','ec.igv', 'de.estado', DB::raw('sum(z.tarifa*de.cantidad) as total'), DB::raw('LPAD(ec.serie,4,0) as serie'),DB::raw('LPAD(ec.correlativo,7,0) as correlativo'))
            ->where('ec.idenvio_encomienda', '=', $idenvio_encomienda)
        //->groupBy('ec.idenvio_encomienda', 'ec.fecha', 'p.nombre', 'ec.tipo_comprobante', 'ec.serie', 'ec.correlativo', 'ec.igv');
            ->first(); //como es un solo ingreso no necesitamos agrupar

        $detalles = DB::table('detalle_envio_encomienda as de')

            ->join('sub_tipo_correspondencia as stc', 'stc.idsub_tipo_correspondencia', '=', 'de.idsub_tipo_correspondencia')
            ->join('zona as z', 'z.idzona', '=', 'de.idzona')
            ->join('departamento_entrega as ce', 'ce.iddepartamento_entrega', '=', 'z.iddepartamento_entrega')
            ->join('departamento as c', 'c.iddepartamento', '=', 'ce.origen')
            ->join('departamento as ci', 'ci.iddepartamento', '=', 'ce.destino')
            ->join('peso as p', 'p.idpeso', '=', 'z.idpeso')

            ->select('de.consignado', 'de.descripcion', 'stc.nombre as nombre_correspondencia', 'c.nombre as origen', 'ci.nombre as destino', 'z.nombre', 'p.minimo', 'p.maximo', 'z.tarifa', 'de.cantidad')
            ->where('de.idenvio_encomienda', '=', $idenvio_encomienda)
            ->get();

        return view("envio.envioEncomienda.show", ["envio_encomienda" => $envio_encomienda, "detalles" => $detalles]);

    }


     public function getCorrelativo(Request $request,$id)
    {
        if ($request->ajax()) {
            $correlativo = EnvioEncomienda::correlativo($id);
            return response()->json($correlativo);
        }
    }


      public function crearPDF($datos,$vistaurl,$tipo)
    {
        //aqui pasan como parametro datos, la url

        $data = $datos;
        $date = date('Y-m-d');
        $view =  \View::make($vistaurl, compact('data', 'date'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        
        if($tipo==1){return $pdf->stream('reporte');}
        if($tipo==2){return $pdf->download('reporte.pdf'); }
    }


    public function crear_reporte_envio_encomienda($tipo){
        //esta funcion sirve para poder pdf por pais
     $vistaurl="envioEncomienda.show";//esto es la ruta html donde se va ir
     $envio_encomiendas=EnvioEncomienda::all();//retornamos todo lo que hay de paises
     return $this->crearPDF($envio_encomienda, $vistaurl,$tipo);
     //aqui llamamos a la funcion crearPdf y le pasamos los paises la url y el tipo

    }


    function getComprobanteFactura(Request $request,$tipo_comprobante)
    {
        if ($request->ajax()) {
            $datos=EnvioEncomienda::comprobanteFactura($tipo_comprobante);
            return response()->json($datos);
        }
    }    

}
