<?php

namespace App\Http\Controllers;

use App\Http\Requests\OperarRequest;
use App\Models\Detalle;
use App\Models\DetalleOperar;
use Illuminate\Http\Request;
use App\Models\Reserva;
use DB;
use App\Models\Operar;
use Carbon\Carbon;
use PDF;
use App\Http\Controllers\Controller;

class OperarController extends Controller
{
    //    
    public function __construct()
    {
        $this->middleware('can:operar.index')->only('index');
        $this->middleware('can:operar.createtour')->only('createtour','createtour');
        $this->middleware('can:operar.destroy')->only('destroy');
        $this->middleware('can:operar.ver')->only('ver');
        $this->middleware('can:operar.edit')->only('edit');
        $this->middleware('can:operar.showtour')->only('showtour','guardarshowtour');
    }
    public function index(Request $request)
    {  
        $i=0;
        $operars=Operar::where('tipo',2)->get();
        // $operas=Operar::whereDate('fecha','=',date('Y-m-d'))->get();
        return view('pages.operar.index',compact('operars','i'));
    }

    public function createtour()
    {
        return view('pages.operar.create');
    }

    public function store(OperarRequest $request)
    {
        try
        {
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');

            $operar=Operar::create([
                'fecha' => $mytime->toDateString(),
                'cantidad' => $request->cantidad,
                'observacion' => "",
                'precio' => $request->precio*$request->cantidad,
                'tour_id' => $request->idTour,
                'user_id' => \Auth::user()->id,
                'monto_dar' => $request->monto_dar,
                'tipo' => 2,
            ]);

            $precio=0;

            foreach($operar->tour->servicios as $i => $servicio){
                $operar->proveedors()->attach($request->idServicio[$servicio->id] ,['monto'=>$request->precioServicio[$servicio->id],'servicio_id'=>$servicio->id]);
                $precio=$precio+$request->precioServicio[$servicio->id];
            }

            $operar->precio=$precio;
            $operar->save();

            foreach($request->detalle as $i => $detalle1){
                $detalless=DetalleOperar::create([
                    'operar_id' => $operar->id,
                    'detalles_id' => $request->detalle[$i],
                    'horarecojo'  => $request->hora[$i],
                ]);
                $detalle=Detalle::find($request->detalle[$i]);
                $detalle->estado=2;
                $detalle->save();
            }

            

            // $cadena="".$cadena."🚐🏞*Tour*: ".$det->tour."%0A🗓*Fecha*: ".$det->fecha."%0A👥*Número de Paxs*: ".$det->numero."%0A🖊*Nombre*: ".$det->cliente." ".$det->apellidos."%0A🛄*Idioma*: ".$det->tipo."%0A*Hotel*: ".$det->hotel."(".$det->direccion.")%0A*Datos Adicionales*%0A*Ingreso*: ".$det->ingreso."%0A*Cel*: ".$det->celular."%0A %0A*Recojo*:".$hora[$cont]."%0A%0A";
            // $ventana="https://api.whatsapp.com/send?phone=&text=".$mensaje;

            // $this->emit('abrir', $ventana);

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('operar.index')
            ->with('success', 'Operación Tour Agregado Correctamente.');
    }

    public function ver(Operar $operar){
        return view('pages.operar.show',compact('operar'));
    }

    public function pdf(Operar $operar)
    { 
        $pdf= \PDF::loadView('pages.pdf.operar-tour',compact('operar'))->setPaper('a4','landscape');
        return $pdf->download('Operacion '.$operar->id.'-'.$operar->tour->nombre.'.pdf');
    }

    public function destroy(Request $request)
    {
        $operar= Operar::findOrFail($request->id_operar);
        if($operar->estado=="1"){
            $operar->estado= '0';
            $operar->save();
            foreach($operar->detallesoperar as $detalle){
                $detalle->estado=1;
                $detalle->save();
            }
            return redirect()->back()->with('success','Opearación Anulado Correctamente');
        }else{
            $operar->estado= '1';
            $operar->save();
            foreach($operar->detallesoperar as $detalle){
                $detalle->estado=2;
                $detalle->save();
            }
            return redirect()->back()->with('success','Opearación Cambiado de Estado Correctamente');
            }
    }

    public function edit(Operar $operar){
        return view('pages.operar.edit',compact('operar'));
    }

    public function update(Operar $operar, OperarRequest $request)
    {
        try
        {
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');

            $operar->update([
                'cantidad' => $request->cantidad,
                'observacion' => $request->observacion,
                'precio' =>$request->cantidad,
                'tour_id' => $request->idTour,
                'monto_dar' => $request->monto_dar,
                'tipo' => 2,
            ]);

            $operar->proveedors()->detach();
            $precio=0;

            foreach($operar->tour->servicios as $i => $servicio){
                $operar->proveedors()->attach($request->idServicio[$servicio->id] ,['monto'=>$request->precioServicio[$servicio->id],'servicio_id'=>$servicio->id]);
                $precio=$precio+$request->precioServicio[$servicio->id];
            }

            $operar->precio=$precio;
            $operar->save();

            foreach($operar->detallesoperar as $detalle)
            {
                $detalles=Detalle::find($detalle->detalles_id);
                $detalles->estado=1;
                $detalles->save();
                $detalle->delete();
            }

            foreach($request->detalle as $i => $detalle1){
                $detalless=DetalleOperar::create([
                    'operar_id' => $operar->id,
                    'detalles_id' => $request->detalle[$i],
                    'horarecojo'  => $request->hora[$i],
                ]);
                $detalle=Detalle::find($request->detalle[$i]);
                $detalle->estado=2;
                $detalle->save();
            }

            foreach($request->detalle2 as $i => $detalle2){
                $detalless=DetalleOperar::create([
                    'operar_id' => $operar->id,
                    'detalles_id' => $request->detalle[$i],
                    'horarecojo'  => $request->hora[$i],
                ]);
                $detalle=Detalle::find($request->detalle[$i]);
                $detalle->estado=2;
                $detalle->save();
            }

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('operar.index')
            ->with('success', 'Operación Tour Editado Correctamente.');
    }

    public function showtour(Operar $operar){
        return view('pages.operar.showoperar',compact('operar'));
    }

    public function showtourguardar(Request $request)
    {
        $operar=Operar::find($request->id_operar);
        foreach($operar->detallesoperar as $detalle)
        {
            if(isset($request->check[$detalle->id])){
                $detalle->detalle->estado=3;
                $detalle->detalle->save();
            }else{
                $detalle->detalle->estado=2;
                $detalle->detalle->save();
            }
        }
        return redirect()->route('operar.index')
        ->with('success', 'Registrado Correctamente.');
    }

    

}
