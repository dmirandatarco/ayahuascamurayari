<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EndoseInnController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:endoseinn.index')->only('index');
        $this->middleware('can:endoseinn.edit')->only('edit','update');
        $this->middleware('can:endoseinn.create')->only('create','store');
        $this->middleware('can:endoseinn.destroy')->only('destroy');
        $this->middleware('can:endoseinn.ver')->only('ver');
    }   

    public function index(Request $request)
    {
        $reservas=Reserva::has('proveedor')->get();
        $i=0;
        return view('pages.endoseinn.index',compact('reservas','i'));
    }

    public function create()
    {
        return view('pages.endoseinn.create');
    }

    public function destroy(Request $request)
    {
        $reserva= Reserva::findOrFail($request->id_endoseinn_2);
        if($reserva->estado=="1"){
            $reserva->estado= '0';
            $reserva->save();
            foreach($reserva->detalles as $detalle){
                $detalle->estado=0;
                $detalle->save();
            }
            return redirect()->back()->with('success','Reserva Anulado Correctamente');
        }else{
            $reserva->estado= '1';
            $reserva->save();
            foreach($reserva->detalles as $detalle){
                $detalle->estado=1;
                $detalle->save();
            }
            return redirect()->back()->with('success','Reserva Cambiado de Estado Correctamente');
        }
    }

    public function edit(Reserva $reserva)
    {
        return view('pages.endoseinn.edit',compact('reserva'));
    }

    public function show(Reserva $reserva)
    {
        return view('pages.endoseinn.show',compact('reserva'));
    }
}

