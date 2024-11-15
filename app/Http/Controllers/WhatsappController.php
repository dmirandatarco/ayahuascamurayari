<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WhatsappRequest;
use App\Models\Whatsapp;

class WhatsappController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:whatsapp.index')->only('index');
        $this->middleware('can:whatsapp.edit')->only('store');
        $this->middleware('can:whatsapp.create')->only('store');
        $this->middleware('can:whatsapp.destroy')->only('destroy');
    }

    public function index()
    {
        $whatsapps=Whatsapp::get();
        $i=0;
        return view('pages.whatsapp.index',compact('whatsapps','i'));
    }

    public function store(WhatsappRequest $request)
    {        
        if($request->tipoform=="crear"){
            Whatsapp::create($request->all());
            return redirect()->route('whatsapp.index')->with('success', 'Whatsapp Creado Correctamente.');
        }else{
            $whatsapp= Whatsapp::findOrFail($request->id_whatsapp);
            $whatsapp->update($request->all());
            return redirect()->back()->with('success','Whatsapp Modificado Correctamente.');
        }
    }

    public function destroy(Request $request)
    {
        $whatsapp= Whatsapp::findOrFail($request->id_whatsapp_2);
        if($whatsapp->estado=="1"){
            $whatsapp->estado= '0';
            $whatsapp->save();
            return redirect()->back()->with('success','Estado de Whatsapp Cambiado Correctamente.');
        }else{
            $whatsapp->estado= '1';
            $whatsapp->save();
            return redirect()->back()->with('success','Estado de Whatsapp Cambiado Correctamente.');
        }
    }
}
