<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:agencia.index')->only('index');
        $this->middleware('can:agencia.edit')->only('update');
        $this->middleware('can:agencia.create')->only('store');
        $this->middleware('can:agencia.destroy')->only('destroy');
    }

    public function index()
    {
        $agencias=Proveedor::whereRelation('servicio','nombre','AGENCIA')->get();
        $i=0;
        return view('pages.agencia.index',compact('agencias','i'));
    }

    public function store(ProveedorRequest $request)
    {    
        if($request->tipoform=="crear"){
            Proveedor::create($request->all());
            return redirect()->route('agencia.index')->with('success', 'Agencia Creado Correctamente.');
        }else{
            $agencia=Proveedor::findOrFail($request->id_proveedor);
            $agencia->update($request->all());
            return redirect()->back()->with('success','Agencia Modificado Correctamente.');
        }
    }
    
    public function update(Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        $agencia= Proveedor::findOrFail($request->id_proveedor_2);
        if($agencia->estado=="1"){
            $agencia->estado= '0';
            $agencia->save();
            return redirect()->back()->with('success','Estado de Agencia Cambiado Correctamente.');
        }else{
            $agencia->estado= '1';
            $agencia->save();
            return redirect()->back()->with('success','Estado de Agencia Cambiado Correctamente.');
        }
    }
}
