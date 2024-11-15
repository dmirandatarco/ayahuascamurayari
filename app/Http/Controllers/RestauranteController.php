<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RestauranteController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:restaurante.index')->only('index');
        $this->middleware('can:restaurante.edit')->only('update');
        $this->middleware('can:restaurante.create')->only('store');
        $this->middleware('can:restaurante.destroy')->only('destroy');
    }

    public function index()
    {
        $restaurantes=Proveedor::whereRelation('servicio','nombre','RESTAURANTE')->get();
        $i=0;
        return view('pages.proveedor.restaurante',compact('restaurantes','i'));
    }

    public function store(ProveedorRequest $request)
    {        
        if($request->tipoform=="crear"){
            Proveedor::create($request->all());
            return redirect()->route('restaurante.index')->with('success', 'Restaurante Creado Correctamente.');
        }else{
            $restaurante= Proveedor::findOrFail($request->id_proveedor);
            $restaurante->update($request->all());
            return redirect()->back()->with('success','Restaurante Modificado Correctamente.');
        }
        
    }
    
    public function update(Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        $restaurante= Proveedor::findOrFail($request->id_proveedor_2);
        if($restaurante->estado=="1"){
            $restaurante->estado= '0';
            $restaurante->save();
            return redirect()->back()->with('success','Estado de Restaurante Cambiado Correctamente.');
        }else{
            $restaurante->estado= '1';
            $restaurante->save();
            return redirect()->back()->with('success','Estado de Restaurante Cambiado Correctamente.');
        }
    }
}
