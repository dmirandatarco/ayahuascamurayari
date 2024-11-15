<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:guia.index')->only('index');
        $this->middleware('can:guia.edit')->only('update');
        $this->middleware('can:guia.create')->only('store');
        $this->middleware('can:guia.destroy')->only('destroy');
    }

    public function index()
    {
        $guias=Proveedor::whereRelation('servicio','nombre','GUIA')->get();
        $i=0;
        return view('pages.proveedor.guia',compact('guias','i'));
    }

    public function store(ProveedorRequest $request)
    {        
        if($request->tipoform=="crear"){
            Proveedor::create($request->all());
            return redirect()->route('guia.index')->with('success', 'Guia Creado Correctamente.');
        }else{
            $guia= Proveedor::findOrFail($request->id_proveedor);
            $guia->update($request->all());
            return redirect()->back()->with('success','Guia Modificado Correctamente.');
        }
    }
    
    public function update(Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        $guia= Proveedor::findOrFail($request->id_proveedor_2);
        if($guia->estado=="1"){
            $guia->estado= '0';
            $guia->save();
            return redirect()->back()->with('success','Estado de Guia Cambiado Correctamente.');
        }else{
            $guia->estado= '1';
            $guia->save();
            return redirect()->back()->with('success','Estado de Guia Cambiado Correctamente.');
        }
    }
}
