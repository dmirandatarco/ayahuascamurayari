<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:hotel.index')->only('index');
        $this->middleware('can:hotel.edit')->only('update');
        $this->middleware('can:hotel.create')->only('store');
        $this->middleware('can:hotel.destroy')->only('destroy');
    }

    public function index()
    {
        $hoteles=Proveedor::whereRelation('servicio','nombre','HOTEL')->get();
        $i=0;
        return view('pages.hotel.index',compact('hoteles','i'));
    }

    public function store(ProveedorRequest $request)
    {        
        if($request->tipoform=="crear"){
            Proveedor::create($request->all());
            return redirect()->route('hotel.index')->with('success', 'Hotel Creado Correctamente.');
        }else{
            $hotel= Proveedor::findOrFail($request->id_proveedor);
            $hotel->update($request->all());
            return redirect()->back()->with('success','Hotel Modificado Correctamente.');
        }
    }

    public function destroy(Request $request)
    {
        $hotel= Proveedor::findOrFail($request->id_proveedor_2);
        if($hotel->estado=="1"){
            $hotel->estado= '0';
            $hotel->save();
            return redirect()->back()->with('success','Estado de Hotel Cambiado Correctamente.');
        }else{
            $hotel->estado= '1';
            $hotel->save();
            return redirect()->back()->with('success','Estado de Hotel Cambiado Correctamente.');
        }
    }
}
