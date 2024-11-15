<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicioRequest;
use App\Models\Servicio;
use App\Models\Tipo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:servicio.index')->only('index');
        $this->middleware('can:servicio.edit')->only('update');
        $this->middleware('can:servicio.create')->only('store');
        $this->middleware('can:servicio.destroy')->only('destroy');
    }

    public function index()
    {
        $servicios=Servicio::where('id','>',5)->get();
        $i=0;
        $tipos=Tipo::where('nombre','!=','AGENCIA')->get();
        return view('pages.servicio.index',compact('servicios','i','tipos'));
    }

    public function store(ServicioRequest $request)
    {        
        if($request->tipoform=="crear"){
            Servicio::create($request->all());
            return redirect()->route('servicio.index')->with('success', 'Servicio Creado Correctamente.');
        }else{
            $servicio= Servicio::findOrFail($request->id_servicio);
            $servicio->update($request->all());
            return redirect()->back()->with('success','Servicio Modificado Correctamente.');
        }
        
    }
    

    public function destroy(Request $request)
    {
        $servicio= Servicio::findOrFail($request->id_servicio_2);
        if($servicio->estado=="1"){
            $servicio->estado= '0';
            $servicio->save();
            return redirect()->back()->with('success','Estado de Servicio Cambiado Correctamente.');
        }else{
            $servicio->estado= '1';
            $servicio->save();
            return redirect()->back()->with('success','Estado de Servicio Cambiado Correctamente.');
        }
    }
}
