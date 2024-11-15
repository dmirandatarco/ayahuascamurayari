<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Paquete;
use Illuminate\Http\Request;

class PaqueteWebController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:paqueteweb.index')->only('index');
        $this->middleware('can:paqueteweb.edit')->only('edit','update');
        $this->middleware('can:paqueteweb.create')->only('create','store');
        $this->middleware('can:paqueteweb.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $paquetes=Paquete::orderBy('id','desc')->where('web',1)->where('estado',1)->get();
        $i=0;
        return view('pages.paqueteweb.index',compact('paquetes','i'));
    }

    public function create()
    {
        return view('pages.paqueteweb.create');
    }

    public function destroy(Request $request)
    {
        $paquete= Paquete::findOrFail($request->paquete_id);
        if($paquete->estado=="1"){
            $paquete->estado= '0';
            $paquete->save();
            return redirect()->back()->with('success','Paquete Anulado Correctamente');
        }else{
            $paquete->estado= '1';
            $paquete->save();
            return redirect()->back()->with('success','Paquete Cambiado de Estado Correctamente');
        }
    }

    public function edit(Paquete $paquete)
    {
        return view('pages.paqueteweb.edit',compact('paquete'));
    }

    public function pdf(Paquete $paquetes)
    {
        $pdf= \PDF::loadView('pages.pdf.pdf-paquete',compact('paquetes'))->setPaper('a4');
        return $pdf->download($paquetes->nombre.'.pdf');
    }

    public function traducir($lang, Paquete $paquete)
    {
        return view('pages.paqueteweb.traducir',compact('paquete','lang'));
    }
}
