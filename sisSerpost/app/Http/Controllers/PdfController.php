<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use sisventas\Http\Controllers\Controller;
use sisventas\DetalleEnvioEncomienda;
use sisventas\EnvioEncomienda;
use DB;

class PdfController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pdf.index");
    } 


      public function crearPDF($datos,$vistaurl,$tipo)
    {
        $data = $datos;
        $envio_encomienda = DB::table('envio_encomienda as ec')

            ->join('persona as p', 'ec.idpersona', '=', 'p.idpersona')
            ->join('detalle_envio_encomienda as de', 'ec.idenvio_encomienda', '=', 'de.idenvio_encomienda')
            ->join('zona as z', 'z.idzona', '=', 'de.idzona')
 
            ->select('ec.idenvio_encomienda', 'ec.fecha', 'p.nombre as nombre_cliente', 'ec.tipo_comprobante', 'ec.serie', 'ec.correlativo', 'ec.igv', 'de.estado', DB::raw('sum(z.tarifa*de.cantidad) as total'))
            ->where('ec.idenvio_encomienda', '=', $idenvio_encomienda)
        //->groupBy('ec.idenvio_encomienda', 'ec.fecha', 'p.nombre', 'ec.tipo_comprobante', 'ec.serie', 'ec.correlativo', 'ec.igv');
            ->first(); //como es un solo ingreso no necesitamos agrupar

        $date = date('Y-m-d');
        $view =  \View::make($vistaurl, compact('data', 'date', 'envio_encomienda'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        if($tipo==1){return $pdf->stream('reporte',["envio_encomienda"=>$envio_encomienda]);}
        if($tipo==2){return $pdf->download('reporte.pdf'); }
    }

    public function crear_reporte_envio_encomienda($tipo){
     //$persona->idventa=$venta->idventa;
     $vistaurl="pdf.reporte_envio_encomienda";
     $envio_encomienda=EnvioEncomienda::all();
     return $this->crearPDF($envio_encomienda, $vistaurl,$tipo);
//venta = datos;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
