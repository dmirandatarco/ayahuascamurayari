<?php

namespace App\Http\Controllers;

use App\Http\Requests\LiquidacionRequest;
use App\Models\Detalle;
use App\Models\DetalleLiquidacion;
use App\Models\Liquidacion;
use App\Models\OperarProveedor;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class LiquidacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:liquidacion.ingreso')->only('ingreso');
        $this->middleware('can:liquidacion.salida')->only('salida');
        $this->middleware('can:liquidacion.ingresocreate')->only('ingresocreate');
        $this->middleware('can:liquidacion.salidacreate')->only('salidacreate');
        $this->middleware('can:liquidacion.destroy')->only('destroy');
        $this->middleware('can:liquidacion.ver')->only('ver');
        $this->middleware('can:liquidacion.edit')->only('edit');
    }
    public function ingreso(Request $request)
    {  
        $i=0;
        $liquidaciones=Liquidacion::where('tipo',1)->get();
        return view('pages.liquidacion.ingreso',compact('liquidaciones','i'));
    }

    public function ingresocreate()
    {
        return view('pages.liquidacion.ingresocreate');
    }

    public function store(LiquidacionRequest $request)
    {
        try
        {
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');

            if($request->tipo==1)
            {
                $liquidacion=Liquidacion::create([
                    'fecha' => $mytime->toDateString(),
                    'acuenta' => $request->acuenta,
                    'monto' => $request->monto,
                    'proveedor_id' => $request->idAgencia,
                    'user_id' => \Auth::user()->id,
                    'tipo' => $request->tipo,
                    'observacion' => $request->observacion,
                ]);

                foreach($request->detalle as $i => $detalle1){
                    $detalless=DetalleLiquidacion::create([
                        'liquidacion_id' => $liquidacion->id,
                        'ejecutable_type' => 'App\Models\Detalle',
                        'ejecutable_id'  => $request->detalle[$i],
                        'cantidad' => $request->cantidad[$i],
                        'precio'  => $request->precio[$i],
                    ]);
                    $detalle=Detalle::find($request->detalle[$i]);
                    $detalle->pago=1;
                    $detalle->save();
                }
            }else{
                $liquidacion=Liquidacion::create([
                    'fecha' => $mytime->toDateString(),
                    'acuenta' => 0,
                    'monto' => $request->monto,
                    'proveedor_id' => $request->idProveedor,
                    'user_id' => \Auth::user()->id,
                    'tipo' => $request->tipo,
                    'observacion' =>$request->observacion,
                ]);
                
                foreach($request->detalle as $i => $detalle1){
                    $detalless=DetalleLiquidacion::create([
                        'liquidacion_id' => $liquidacion->id,
                        'ejecutable_type' => 'App\Models\OperarProveedor',
                        'ejecutable_id'  => $request->detalle[$i],
                        'cantidad' => $request->cantidad[$i],
                        'precio'  => $request->precio[$i],
                    ]);
                    $detalle=OperarProveedor::find($request->detalle[$i]);
                    $detalle->estado=1;
                    $detalle->save();
                }
            }
            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        if($request->tipo==1)
        {
            return redirect()->route('liquidacion.ingreso')
            ->with('success', 'Liquidacion Agregado Correctamente.');
        }else{
            return redirect()->route('liquidacion.salida')
            ->with('success', 'Liquidacion Agregado Correctamente.');
        }
    }

    public function ver(Liquidacion $liquidacion){
        return view('pages.liquidacion.show',compact('liquidacion'));
    }

    public function pdf(Liquidacion $liquidacion)
    { 
        $pdf= \PDF::loadView('pages.pdf.liquidacion',compact('liquidacion'))->setPaper('a4');
        return $pdf->download('Liquidacion '.$liquidacion->fecha.'-'.$liquidacion->proveedor->nombre.'.pdf');
    }

    public function destroy(Request $request)
    {
        $liquidacion= Liquidacion::findOrFail($request->liquidacion_id);
        if($liquidacion->estado=="1"){
            $liquidacion->estado= '0';
            $liquidacion->save();
            foreach($liquidacion->detallesliquidacion as $detalle){
                if($detalle->ejecutable_type=="App\Models\Detalle"){
                    $detalle->ejecutable->pago=0;
                    $detalle->ejecutable->save();
                }else{
                    $detalle->ejecutable->estado=0;
                    $detalle->ejecutable->save();
                }
                
            }
            return redirect()->back()->with('success','Liquidacion Anulado Correctamente');
        }else{
            $liquidacion->estado= '1';
            $liquidacion->save();
            foreach($liquidacion->detallesliquidacion as $detalle){
                if($detalle->ejecutable_type=="App\Models\Detalle"){
                    $detalle->ejecutable->pago=1;
                    $detalle->ejecutable->save();
                }else{
                    $detalle->ejecutable->estado=1;
                    $detalle->ejecutable->save();
                }
            }
            return redirect()->back()->with('success','Liquidacion Cambiado de Estado Correctamente');
            }
    }

    public function salida(Request $request)
    {  
        $i=0;
        $liquidaciones=Liquidacion::where('tipo',2)->get();
        return view('pages.liquidacion.salida',compact('liquidaciones','i'));
    }

    public function salidacreate()
    {
        return view('pages.liquidacion.salidacreate');
    }

}
