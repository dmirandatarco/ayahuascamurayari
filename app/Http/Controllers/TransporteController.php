<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:transporte.index')->only('index');
        $this->middleware('can:transporte.edit')->only('update');
        $this->middleware('can:transporte.create')->only('store');
        $this->middleware('can:transporte.destroy')->only('destroy');
    }

    public function index()
    {
        $transportes=Proveedor::whereRelation('servicio','nombre','TRANSPORTE')->get();
        $i=0;
        return view('pages.proveedor.transporte',compact('transportes','i'));
    }

    public function store(ProveedorRequest $request)
    {        
        if($request->tipoform=="crear"){
            Proveedor::create($request->all());
            return redirect()->route('transporte.index')->with('success', 'Transporte Creado Correctamente.');
        }else{
            $transporte= Proveedor::findOrFail($request->id_proveedor);
            $transporte->update($request->all());
            return redirect()->back()->with('success','Transporte Modificado Correctamente.');
        }
        
    }
    
    public function update(Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        $transporte= Proveedor::findOrFail($request->id_proveedor_2);
        if($transporte->estado=="1"){
            $transporte->estado= '0';
            $transporte->save();
            return redirect()->back()->with('success','Estado de Transporte Cambiado Correctamente.');
        }else{
            $transporte->estado= '1';
            $transporte->save();
            return redirect()->back()->with('success','Estado de Transporte Cambiado Correctamente.');
        }
    }
}
