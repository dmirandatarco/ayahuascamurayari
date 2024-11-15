<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use App\Models\Servicio;
use App\Models\Tipo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:proveedor.index')->only('index');
        $this->middleware('can:proveedor.edit')->only('update');
        $this->middleware('can:proveedor.create')->only('store');
        $this->middleware('can:proveedor.destroy')->only('destroy');
    }

    public function index()
    {
        $proveedores=Proveedor::whereRelation('servicio','nombre','!=','AGENCIA')->whereRelation('servicio','nombre','!=','HOTEL')
        ->whereRelation('servicio','nombre','!=','GUIA')->whereRelation('servicio','nombre','!=','TRANSPORTE')
        ->whereRelation('servicio','nombre','!=','RESTAURANTE')->get();
        $servicios=Tipo::where('nombre','!=','AGENCIA')->get();
        $i=0;
        return view('pages.proveedor.index',compact('proveedores','i','servicios'));
    }

    public function store(ProveedorRequest $request)
    {        
        if($request->tipoform=="crear"){
            Proveedor::create($request->all());
            return redirect()->route('proveedor.index')->with('success', 'Proveedor Creado Correctamente.');
        }else{
            $proveedor= Proveedor::findOrFail($request->id_proveedor);
            $proveedor->update($request->all());
            return redirect()->back()->with('success','Proveedor Modificado Correctamente.');
        }
        
    }
    
    public function update(Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        $proveedor= Proveedor::findOrFail($request->id_proveedor_2);
        if($proveedor->estado=="1"){
            $proveedor->estado= '0';
            $proveedor->save();
            return redirect()->back()->with('success','Estado de Proveedor Cambiado Correctamente.');
        }else{
            $proveedor->estado= '1';
            $proveedor->save();
            return redirect()->back()->with('success','Estado de Proveedor Cambiado Correctamente.');
        }
    }
}
