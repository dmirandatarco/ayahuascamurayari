<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedioRequest;
use App\Models\Medio;
use App\Models\Moneda;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MedioController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:medio.index')->only('index');
        $this->middleware('can:medio.edit')->only('update');
        $this->middleware('can:medio.create')->only('store');
        $this->middleware('can:medio.destroy')->only('destroy');
    }

    public function index()
    {
        $medios=Medio::all();
        $i=0;
        $monedas=Moneda::all();
        return view('pages.medio.index',compact('medios','i','monedas'));
    }

    public function store(MedioRequest $request)
    {        
        if($request->tipoform=="crear"){
            Medio::create($request->all());
            return redirect()->route('medio.index')->with('success', 'Medio de Pago Creado Correctamente.');
        }else{
            $medio= Medio::findOrFail($request->id_medio);
            $medio->update($request->all());
            return redirect()->back()->with('success','Medio de Pago Modificado Correctamente.');
        }
        
    }
    
    public function update(Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        $medio= Medio::findOrFail($request->id_medio_2);
        if($medio->estado=="1"){
            $medio->estado= '0';
            $medio->save();
            return redirect()->back()->with('success','Estado de Medio de Pago Cambiado Correctamente.');
        }else{
            $medio->estado= '1';
            $medio->save();
            return redirect()->back()->with('success','Estado de Medio de Pago Cambiado Correctamente.');
        }
    }
}
