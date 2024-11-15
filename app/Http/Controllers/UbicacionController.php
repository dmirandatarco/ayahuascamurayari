<?php

namespace App\Http\Controllers;

use App\Http\Requests\UbicacionRequest;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Language;

class UbicacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:ubicacion.index')->only('index');
        $this->middleware('can:ubicacion.edit')->only('update');
        $this->middleware('can:ubicacion.create')->only('store');
    }

    public function index()
    {
        $ubicacions=Ubicacion::all();
        $i=0;
        return view('pages.ubicacion.index',compact('ubicacions','i'));
    }

    public function store(UbicacionRequest $request)
    {
        $idioma=Language::find($request->language_id);
        if($request->tipoform=="crear"){
            if($request->hasFile('imagen'))
            {
                 // Verificar si el archivo es de tipo .heic
                if ($request->imagen->getClientOriginalExtension() == 'heic' || $request->imagen->getClientOriginalExtension() == 'HEIC') {
                    // Realizar la conversión a .jpg y guardar en la misma ruta que FileManager
                    $fileManagerPath = public_path('storage/img/ubicaciones/');
                    $nombreimg=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
                    \Maestroerror\HeicToJpg::convert($request->imagen)->saveAs($fileManagerPath . $nombreimg);
                    $ruta='img/ubicaciones/'.$nombreimg;        
                } else {
                    $nombreimg=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
                    $ruta=$request->imagen->storeAs('img/ubicaciones',$nombreimg);
                }
                Image::make('storage/'.$ruta)->fit(1600, 1200, function ($constraint) {
                    $constraint->upsize();
                })->encode('webp')
                ->save('storage/'.$ruta);
            }
            $request['slug']=Str::slug($request->nombre,'-');
            $ubicacion=Ubicacion::create($request->all());
            $ubicacion->image()->create(['nombre'=>$nombreimg]);
            return redirect()->route('ubicacion.index')->with('success', 'Ubicacion Creado Correctamente.');
        }elseif($request->tipoform=="editar"){
            $ubicacion= Ubicacion::findOrFail($request->id_ubicacion);
            if($request->hasFile('imagen'))
            {
                $ubicacion->image()->delete();
                if ($request->imagen->getClientOriginalExtension() == 'heic' || $request->imagen->getClientOriginalExtension() == 'HEIC') {
                    // Realizar la conversión a .jpg y guardar en la misma ruta que FileManager
                    $fileManagerPath = public_path('storage/img/ubicaciones/');
                    $nombreimg=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
                    \Maestroerror\HeicToJpg::convert($request->imagen)->saveAs($fileManagerPath . $nombreimg);
                    $ruta='img/ubicaciones/'.$nombreimg;        
                } else {
                    $nombreimg=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
                    $ruta=$request->imagen->storeAs('img/ubicaciones',$nombreimg);
                }
                Image::make('storage/'.$ruta)->fit(1600, 1200, function ($constraint) {
                    $constraint->upsize();
                })->encode('webp')
                ->save('storage/'.$ruta);
                $ubicacion->image()->create(['nombre'=>$nombreimg]);
            }
            $request['slug']=Str::slug($request->nombre,'-');
            $ubicacion->update($request->all());
            return redirect()->back()->with('success','Ubicacion Modificado Correctamente.');
        }else{
            $ubicacion= Ubicacion::findOrFail($request->id_ubicacion);
            $ubicaciontraducida=Ubicacion::create([
                'nombre' => $request->nombre,
                'slug' => Str::slug($request->nombre,'-'),
                'descripcion' => $request->descripcion,
                'language_id' => $request->language_id,
            ]);

            if($request->imagen){
                if ($request->imagen->getClientOriginalExtension() == 'heic' || $request->imagen->getClientOriginalExtension() == 'HEIC') {
                    // Realizar la conversión a .jpg y guardar en la misma ruta que FileManager
                    $fileManagerPath = public_path('storage/img/ubicaciones/');
                    $nombreimg=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
                    \Maestroerror\HeicToJpg::convert($request->imagen)->saveAs($fileManagerPath . $nombreimg);
                    $ruta='img/ubicaciones/'.$nombreimg;        
                } else {
                    $nombreimg=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
                    $ruta=$request->imagen->storeAs('img/ubicaciones',$nombreimg);
                }
                Image::make('storage/'.$ruta)->fit(1600, 1200, function ($constraint) {
                    $constraint->upsize();
                })->encode('webp')
                ->save('storage/'.$ruta);
                $ubicaciontraducida->image()->create(['nombre'=>$nombreimg]);

            }else{
                $nombreimagenfinal = str_replace(env('URL_WEB') . '/storage/img/ubicaciones/', '', $ubicacion->image->nombre);
                list($nombre,$extension ) = explode(".", $nombreimagenfinal);
                $imagenprincipal=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.'.$extension;
                Storage::copy('img/ubicaciones/'.$nombreimagenfinal, 'img/ubicaciones/'.$imagenprincipal);
                $ubicaciontraducida->image()->create(['nombre'=>$imagenprincipal]);
            }

            if($ubicacion->traducciones){
                foreach($ubicacion->traducciones as $traduccion){
                    $traduccion->traducciones()->attach($ubicaciontraducida->id,['table'=>'ubicacions','language_id'=>$request->language_id]);
                }
            }
            if($ubicacion->traduccionesinversas){
                foreach($ubicacion->traduccionesinversas as $traduccion){
                    $traduccion->traducciones()->attach($ubicaciontraducida->id,['table'=>'ubicacions','language_id'=>$request->language_id]);
                }
            }
            $ubicacion->traducciones()->attach($ubicaciontraducida->id,['table'=>'ubicacions','language_id'=>$request->language_id]);
            return redirect()->back()->with('success','Ubicacion Traducida Correctamente.');
        }

    }


}
