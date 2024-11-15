<?php

namespace App\Http\Controllers;

use App\Http\Requests\EndoseOutRequest;
use App\Models\Detalle;
use App\Models\DetalleOperar;
use App\Models\Operar;
use App\Models\Reserva;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class EndoseOutController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:endoseout.index')->only('index');
        $this->middleware('can:endoseout.edit')->only('edit','update');
        $this->middleware('can:endoseout.create')->only('create','store');
        $this->middleware('can:endoseout.destroy')->only('destroy');
        $this->middleware('can:endoseout.ver')->only('ver');
    }   

    public function index(Request $request)
    {
        $operars=Operar::where('tipo',1)->get();
        // $reservas=Reserva::whereDate('fecha','=',date('Y-m-d'))->get();
        $i=0;
        return view('pages.endoseout.index',compact('operars','i'));
    }

    public function create()
    {
        return view('pages.endoseout.create');
    }

    public function destroy(Request $request)
    {
        $operar= Operar::findOrFail($request->id_endoseout_2);
        if($operar->estado=="1"){
            $operar->estado= '0';
            $operar->save();
            foreach($operar->detallesoperar as $detalle){
                $detalle->estado=1;
                $detalle->save();
            }
            return redirect()->back()->with('success','Endose Out Anulado Correctamente');
        }else{
            $operar->estado= '1';
            $operar->save();
            foreach($operar->detallesoperar as $detalle){
                $detalle->estado=2;
                $detalle->save();
            }
            return redirect()->back()->with('success','Endose Out Cambiado de Estado Correctamente');
            }
    }

    public function store(EndoseOutRequest $request)
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
                'monto_dar' => 0,
                'tipo' => 1,
            ]);

            $operar->proveedors()->attach($request->agencia_id ,['monto'=>$request->precio*$request->cantidad,'servicio_id'=>2]);

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
        return redirect()->route('endoseout.index')
            ->with('success', 'Endose Out Agregado Correctamente.');
    }

    public function ver(Operar $operar)
    {
        return view('pages.endoseout.show',compact('operar'));
    }

    public function mensaje(Operar $operar)
    {
        $cadena="";
        foreach($operar->detallesoperar as $detalle)
        {

            $cadena="".$cadena."🚐🏞*Tour*: ".$detalle->detalle->tour->nombre."%0A🗓*Fecha*: ".$detalle->detalle->fecha_viaje."%0A👥*Número de Paxs*: ".$detalle->detalle->cantidad."%0A🖊*Nombre*: ".$detalle->detalle->reserva->pasajero->nombre."%0A🛄*Pais*: ".$detalle->detalle->reserva->pasajero->pais->nombre."%0A*Hotel*: ".$detalle->detalle->hotel->nombre."(".$detalle->detalle->hotel->direcion.")%0A*Ingreso*: ".$detalle->detalle->ingreso."%0A*Datos Adicionales*%0A*Cel*: ".$detalle->detalle->reserva->pasajero->celular."%0A %0A*Recojo*:".$detalle->horarecojo."%0A%0A";
        }
        return redirect("https://api.whatsapp.com/send?phone=&text=".$cadena);
    }

    public function edit(Operar $operar){
        return view('pages.endoseout.edit',compact('operar'));
    }

    public function update(Operar $operar, EndoseOutRequest $request)
    {
        try
        {
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');

            $operar->update([
                'cantidad' => $request->cantidad,
                'observacion' => "",
                'precio' => $request->precio*$request->cantidad,
                'tour_id' => $request->idTour,
                'tipo' => 1,
            ]);

            $operar->proveedors()->detach();

            $operar->proveedors()->attach($request->agencia_id ,['monto'=>$request->precio*$request->cantidad,'servicio_id'=>2]);

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

            foreach($request->detalle2 as $j => $detalle2){
                $detalless=DetalleOperar::create([
                    'operar_id' => $operar->id,
                    'detalles_id' => $request->detalle2[$j],
                    'horarecojo'  => $request->hora2[$j],
                ]);
                $detalle=Detalle::find($request->detalle2[$j]);
                $detalle->estado=2;
                $detalle->save();
            }

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('endoseout.index')
            ->with('success', 'Endose Out Editado Correctamente.');
    }

}
