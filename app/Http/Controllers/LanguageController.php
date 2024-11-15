<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Support\Str;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:language.index')->only('index');
        $this->middleware('can:language.edit')->only('update');
        $this->middleware('can:language.create')->only('store');
        $this->middleware('can:language.destroy')->only('destroy');
    }

    public function index()
    {
        $idiomas=Language::get();
        $i=0;
        return view('pages.idioma.index',compact('idiomas','i'));
    }

    public function store(LanguageRequest $request)
    {    
        if($request->tipoform=="crear"){
            $idioma = new Language();
            $idioma->abreviatura = $request->abreviatura;
            if($request->hasFile('icono'))
            {
                $nombreimg=Str::slug($request->abreviatura,'-').'.'.$request->file('icono')->getClientOriginalExtension();
                $ruta=$request->icono->storeAs('img/idioma',$nombreimg);
                $idioma->icono = $nombreimg;
            }
            $idioma->save();
            return redirect()->route('language.index')->with('success', 'Idioma Creado Correctamente.');
        }else{
            $idioma=Language::findOrFail($request->id_idioma);
            $idioma->abreviatura = $request->abreviatura;
            if($request->hasFile('icono'))
            {
                $nombreimg=Str::slug($request->abreviatura,'-').'.'.$request->file('icono')->getClientOriginalExtension();
                $ruta=$request->icono->storeAs('img/idioma',$nombreimg); 
                $idioma->icono = $nombreimg;
            }
            $idioma->save();
            return redirect()->back()->with('success','Idioma Modificado Correctamente.');
        }
    }
    
    public function update(Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        $idioma= Language::findOrFail($request->id_idioma_2);
        if($idioma->estado=="1"){
            $idioma->estado= '0';
            $idioma->save();
            return redirect()->back()->with('success','Estado de Idioma Cambiado Correctamente.');
        }else{
            $idioma->estado= '1';
            $idioma->save();
            return redirect()->back()->with('success','Estado de Idioma Cambiado Correctamente.');
        }
    }
}
