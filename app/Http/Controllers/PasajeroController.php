<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasajeroRequest;
use App\Models\Pais;
use App\Models\Pasajero;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasajeroController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:pasajero.index')->only('index');
        $this->middleware('can:pasajero.edit')->only('update');
        $this->middleware('can:pasajero.create')->only('store');
    }

    public function index()
    {
        $pasajeros=Pasajero::all()->chunk(300);
        $i=0;
        $paises=Pais::all()->chunk(100);
        return view('pages.pasajero.index',compact('pasajeros','i','paises'));
    }

    public function store(PasajeroRequest $request)
    {    
        if($request->tipoform=="crear"){
            Pasajero::create($request->all());
            return redirect()->route('pasajero.index')->with('success', 'Pasajero Creado Correctamente.');
        }else{
            $pasajero=Pasajero::findOrFail($request->id_pasajero);
            $pasajero->update($request->all());
            return redirect()->back()->with('success','Pasajero Modificado Correctamente.');
        }
    }
    
    public function update(Request $request)
    {
        $pasajero=Pasajero::findOrFail($request->id_pasajero);
        $pasajero->update($request->all());
        return redirect()->back()->with('success','Pasajero Modificado Correctamente.');
    }
}
