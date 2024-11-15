<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:menu.index')->only('index');
        $this->middleware('can:menu.edit')->only('update');
        $this->middleware('can:menu.create')->only('store');
        $this->middleware('can:menu.destroy')->only('destroy');
    }

    public function index()
    {
        $menus=Menu::all();
        $i=0;
        return view('pages.menu.index',compact('menus','i'));
    }

    public function create()
    {
        return view('pages.menu.create');
    }

    public function traducir($lang,Menu $menu)
    {
        return view('pages.menu.traducir',compact('lang','menu'));
    }

    public function edit(Menu $menu)
    {
        return view('pages.menu.edit',compact('menu'));
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
