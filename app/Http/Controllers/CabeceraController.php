<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cabecera;
use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


use DB;

class CabeceraController extends Controller
{
    //
    public function index()
    {
        $cabeceras = Cabecera::all();
        return view('pages.cabecera.index',compact('cabeceras'));

    }
    public function lista(Cabecera $cabecera)
    {

        return view('pages.cabecera.index',compact('cabecera'));
    }
    public function create()
    {

        return view('pages.cabecera.create');
    }
    public function edit(Cabecera $cabecera)
    {

        return view('pages.cabecera.edit',compact('cabecera'));
    }

    public function store(Request $request)
    {
        try
        {
            $idioma=Language::find($request->language_id);

            $cabecera = new Cabecera();
            $cabecera->nombre = $request->nombre;
            $cabecera->user_id = \Auth::user()->id;
            $cabecera->video = $request->video;
            $cabecera->language_id = $request->language_id;
            $cabecera->tipo = $request->tipo ? '1' : '0' ;
            $cabecera->save();


            DB::beginTransaction();
            foreach($request->imagenes as $i => $imagen){
                list($nombre2,$extension2 ) = explode(".", $imagen);
                $imagen12=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'-'.$i.'.'.$extension2;
                Storage::move('livewire-tmp/'.$imagen, 'img/cabecera/'.$imagen12);
                $ruta='img/cabecera/'.$imagen12;
                Image::make('storage/'.$ruta)->fit(1600, 1200, function ($constraint) {
                    $constraint->upsize();
                })->save('storage/'.$ruta,null,'jpg');
                $cabecera->images()->create(['nombre'=>$imagen12]);
            }
            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('cabecera.create')
            ->with('success', 'Cabecera Agregado Correctamente.');
    }
    public function destroy(Request $request)
    {
        $cabeceras = Cabecera::all();
        foreach ($cabeceras as $cabecera) {
            $cabecera->estado = '0';
            $cabecera->save();
        }
        $cabeceraDeseada = Cabecera::findOrFail($request->id_cabecera_2);
        $cabeceraDeseada->estado = '1';
        $cabeceraDeseada->save();
        foreach($cabeceraDeseada->traducciones as $cabecera){
            $cabecera->estado = '1';
            $cabecera->save();
        }
        foreach($cabeceraDeseada->traduccionesinversas as $cabecera){
            $cabecera->estado = '1';
            $cabecera->save();
        }
        return redirect()->back()->with('success','Estado de Cabecera Cambiado Correctamente.');
    }
    public function show(Cabecera $cabecera)
    {
        return view('pages.cabecera.show',compact('cabecera'));
    }

    public function traducir($lang, Cabecera $cabecera)
    {


        return view('pages.cabecera.traducir',compact('cabecera','lang'));
    }

}
