<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Language;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:categoria.index')->only('index');
        $this->middleware('can:categoria.edit')->only('update');
        $this->middleware('can:categoria.create')->only('store');
    }

    public function index()
    {
        $categorias=Categoria::all();
        $i=0;
        return view('pages.categoria.index',compact('categorias','i'));
    }

    public function store(CategoriaRequest $request)
    {
        $idioma=Language::find($request->language_id);
        if($request->tipoform=="crear"){
            if($request->hasFile('imagen'))
            {
                 // Verificar si el archivo es de tipo .heic
                if ($request->imagen->getClientOriginalExtension() == 'heic' || $request->imagen->getClientOriginalExtension() == 'HEIC') {
                    // Realizar la conversión a .jpg y guardar en la misma ruta que FileManager
                    $fileManagerPath = public_path('storage/img/categorias/');
                    $nombreimg=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
                    \Maestroerror\HeicToJpg::convert($request->imagen)->saveAs($fileManagerPath . $nombreimg);
                    $ruta='img/categorias/'.$nombreimg;        
                } else {
                    $nombreimg=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
                    $ruta=$request->imagen->storeAs('img/categorias',$nombreimg);
                }
                Image::make('storage/'.$ruta)->fit(1600, 1200, function ($constraint) {
                    $constraint->upsize();
                })->encode('webp')
                ->save('storage/'.$ruta);
            }
            $request['slug']=Str::slug($request->nombre,'-');
            $categoria=Categoria::create($request->all());
            $categoria->image()->create(['nombre'=>$nombreimg]);
            return redirect()->route('categoria.index')->with('success', 'Categoria Creado Correctamente.');
        }elseif($request->tipoform=="editar"){
            $categoria= Categoria::findOrFail($request->id_categoria);
            if($request->hasFile('imagen'))
            {
                $categoria->image()->delete();
                // Verificar si el archivo es de tipo .heic
                if ($request->imagen->getClientOriginalExtension() == 'heic' || $request->imagen->getClientOriginalExtension() == 'HEIC') {
                    // Realizar la conversión a .jpg y guardar en la misma ruta que FileManager
                    $fileManagerPath = public_path('storage/img/categorias/');
                    $nombreimg=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
                    \Maestroerror\HeicToJpg::convert($request->imagen)->saveAs($fileManagerPath . $nombreimg);
                    $ruta='img/categorias/'.$nombreimg;        
                } else {
                    $nombreimg=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
                    $ruta=$request->imagen->storeAs('img/categorias',$nombreimg);
                }
                Image::make('storage/'.$ruta)->fit(1600, 1200, function ($constraint) {
                    $constraint->upsize();
                })->encode('webp')
                ->save('storage/'.$ruta);
                $categoria->image()->create(['nombre'=>$nombreimg]);
            }
            $request['slug']=Str::slug($request->nombre,'-');
            $categoria->update($request->all());
            return redirect()->back()->with('success','Categoria Modificado Correctamente.');
        }else{
            $categoria= Categoria::findOrFail($request->id_categoria);
            $categoriatraducida=Categoria::create([
                'nombre' => $request->nombre,
                'slug' => Str::slug($request->nombre,'-'),
                'descripcion' => $request->descripcion,
                'language_id' => $request->language_id,
            ]);

            if($request->imagen){
                // Verificar si el archivo es de tipo .heic
                if ($request->imagen->getClientOriginalExtension() == 'heic' || $request->imagen->getClientOriginalExtension() == 'HEIC') {
                    // Realizar la conversión a .jpg y guardar en la misma ruta que FileManager
                    $fileManagerPath = public_path('storage/img/categorias/');
                    $nombreimg=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
                    \Maestroerror\HeicToJpg::convert($request->imagen)->saveAs($fileManagerPath . $nombreimg);
                    $ruta='img/categorias/'.$nombreimg;        
                } else {
                    $nombreimg=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
                    $ruta=$request->imagen->storeAs('img/categorias',$nombreimg);
                }
                Image::make('storage/'.$ruta)->fit(1600, 1200, function ($constraint) {
                    $constraint->upsize();
                })->encode('webp')
                ->save('storage/'.$ruta);
                $categoriatraducida->image()->create(['nombre'=>$nombreimg]);

            }else{
                $nombreimagenfinal = str_replace(env('URL_WEB') . '/storage/img/categorias/', '', $categoria->image->nombre);
                list($nombre,$extension ) = explode(".", $nombreimagenfinal);
                $imagenprincipal=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.'.$extension;
                Storage::copy('img/categorias/'.$nombreimagenfinal, 'img/categorias/'.$imagenprincipal);
                $categoriatraducida->image()->create(['nombre'=>$imagenprincipal]);
            }

            if($categoria->traducciones){
                foreach($categoria->traducciones as $traduccion){
                    $traduccion->traducciones()->attach($categoriatraducida->id,['table'=>'categorias','language_id'=>$request->language_id]);
                }
            }
            if($categoria->traduccionesinversas){
                foreach($categoria->traduccionesinversas as $traduccion){
                    $traduccion->traducciones()->attach($categoriatraducida->id,['table'=>'categorias','language_id'=>$request->language_id]);
                }
            }
            $categoria->traducciones()->attach($categoriatraducida->id,['table'=>'categorias','language_id'=>$request->language_id]);
            return redirect()->back()->with('success','Categoria Traducida Correctamente.');
        }

    }

    public function update(Request $request)
    {

    }

}
