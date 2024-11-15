<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use DB;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:blog.index')->only('index');
        $this->middleware('can:blog.edit')->only('update');
        $this->middleware('can:blog.create')->only('store');
        $this->middleware('can:blog.destroy')->only('destroy');
    }

    public function index()
    {
        $blogs=Blog::all();
        $i=0;
        return view('pages.blog.index',compact('blogs','i'));
    }

    public function create()
    {
        $idiomas=Language::where('estado',1)->get();
        return view('pages.blog.create',compact('idiomas'));
    }

    public function store(BlogRequest $request)
    {
        $idioma=Language::find($request->language_id);
        try
        {
            $mytime= Carbon::now('America/Lima');
            DB::beginTransaction();
            list($nombre,$extension ) = explode(".", $request->imagenprincipal);
            $imagenprincipal=$idioma->abreviatura.'-'.Str::slug($request->titulo,'-').'.webp';
            Storage::move('livewire-tmp/'.$request->imagenprincipal, 'img/blog/'.$imagenprincipal);
            $ruta='img/blog/'.$imagenprincipal;
            Image::make('storage/'.$ruta)->orientate()->encode('webp')
            ->save('storage/'.$ruta);

            $request['imagenprincipal']=$imagenprincipal;
            $request['slug']=Str::slug($request->titulo,'-');
            $request['user_id']=\Auth::user()->id;
            $request['fecha']= $mytime->toDateString();
            $tour=Blog::create($request->all());
            foreach($request->imagenes ?? [] as $i => $imagen){
                list($nombre2,$extension2 ) = explode(".", $imagen);
                $imagen12=$idioma->abreviatura.'-'.Str::slug($request->titulo,'-').'-'.$i.'.webp';
                Storage::move('livewire-tmp/'.$imagen, 'img/blog/'.$imagen12);
                $ruta='img/blog/'.$imagen12;

                Image::make('storage/'.$ruta)->orientate()->encode('webp')
                ->save('storage/'.$ruta);
                $tour->images()->create(['nombre'=>$imagen12]);
            }
            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('blog.index')
            ->with('success', 'Blog Agregado Correctamente.');
    }

    public function edit(Blog $blog)
    {
        $idiomas=Language::where('estado',1)->get();
        return view('pages.blog.edit',compact('blog','idiomas'));
    }

    public function update(BlogRequest $request,Blog $blog)
    {
        $idioma=Language::find($request->language_id);
        try
        {
            DB::beginTransaction();
            if($request->imagenprincipal!=""){
                list($nombre,$extension ) = explode(".", $request->imagenprincipal);
                $imagenprincipal=$idioma->abreviatura.'-'.Str::slug($request->titulo,'-').'.webp';
                Storage::move('livewire-tmp/'.$request->imagenprincipal, 'img/blog/'.$imagenprincipal);
                $ruta='img/blog/'.$imagenprincipal;
                Image::make('storage/'.$ruta)->orientate()->encode('webp')
                ->save('storage/'.$ruta);
                $request['imagenprincipal']=$imagenprincipal;
            }
            $request['slug']=Str::slug($request->titulo,'-');
            $blog->update($request->all());
            
            $blog->images()->delete();
            $imagenesanteriores=json_decode($request->imagenes2);

            $i=0;
            foreach($imagenesanteriores ?? [] as $imagen2){
                $nombreimagenfinal = str_replace(env('URL_WEB') . '/storage/img/blog/', '',  $imagen2->nombre);
                list($nombre2,$extension24 ) = explode(".", $nombreimagenfinal);
                $imagen121=$idioma->abreviatura.'-'.Str::slug($request->titulo,'-').'-'.$i.'.webp';
                Storage::copy('img/blog/'.$nombreimagenfinal, 'img/blog/'.$imagen121);

                $blog->images()->create(['nombre'=>$imagen121]);
                $i++;
            }
            foreach ($request->imagenes ?? [] as $imagen) {
                list($nombre2, $extension2) = explode(".", $imagen);
                $imagen12 = $idioma->abreviatura.'-'.Str::slug($request->titulo,'-').'-'.$i.'.webp';
                Storage::move('livewire-tmp/'.$imagen, 'img/blog/'.$imagen12);
                $ruta = 'img/blog/'.$imagen12;
                Image::make('storage/'.$ruta)->orientate()->encode('webp')
                ->save('storage/'.$ruta);
                $blog->images()->create(['nombre' => $imagen12]);
                $i++;
            }
            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('blog.index')->with('success','Blog Modificado Correctamente!');
    }

    public function traducir($lang, Blog $blog)
    {
        return view('pages.blog.traducir',compact('blog','lang'));
    }

    public function blogtraducido(BlogRequest $request,Blog $blog)
    {
        $idioma=Language::find($request->language_id);
        try
        {
            DB::beginTransaction();
            if($request->imagenprincipal){
                list($nombre,$extension ) = explode(".", $request->imagenprincipal);
                $imagenprincipal=$idioma->abreviatura.'-'.Str::slug($request->titulo,'-').'.webp';
                Storage::move('livewire-tmp/'.$request->imagenprincipal, 'img/blog/'.$imagenprincipal);
                $ruta='img/blog/'.$imagenprincipal;
                Image::make('storage/'.$ruta)->orientate()->encode('webp')
                ->save('storage/'.$ruta);
                $request['imagenprincipal']=$imagenprincipal;
            }else{
                $nombreimagenfinal = str_replace(env('URL_WEB') . '/storage/img/blog/', '',  $blog->imagenprincipal);
                list($nombre,$extension ) = explode(".", $nombreimagenfinal);
                $imagenprincipal=$idioma->abreviatura.'-'.Str::slug($request->titulo,'-').'.webp';
                Storage::copy('img/blog/'.$nombreimagenfinal, 'img/blog/'.$imagenprincipal);
                $request['imagenprincipal']=$imagenprincipal;
            }

            $request['slug']=Str::slug($request->titulo,'-');
            $request['user_id']=$blog->user_id;
            $request['fecha']= $blog->fecha;
            $blogtraducido=Blog::create($request->all());
            $imagenesanteriores=json_decode($request->imagenes2);
            $i=1;
            foreach($imagenesanteriores ?? [] as $imagen2){
                $nombreimagenfinal = str_replace(env('URL_WEB') . '/storage/img/blog/', '',  $imagen2->nombre);
                list($nombre2,$extension24 ) = explode(".", $nombreimagenfinal);
                $imagen121=$idioma->abreviatura.'-'.Str::slug($request->titulo,'-').'-'.$i.'.webp';
                Storage::copy('img/blog/'.$nombreimagenfinal, 'img/blog/'.$imagen121);
                $blogtraducido->images()->create(['nombre'=>$imagen121]);
                $i++;
            }
            foreach($request->imagenes ?? [] as $imagen){
                list($nombre2,$extension2 ) = explode(".", $imagen);
                $imagen12=$idioma->abreviatura.'-'.Str::slug($request->titulo,'-').'-'.$i.'.webp';
                Storage::move('livewire-tmp/'.$imagen, 'img/blog/'.$imagen12);
                $ruta='img/blog/'.$imagen12;
                Image::make('storage/'.$ruta)->orientate()->encode('webp')
                ->save('storage/'.$ruta);
                $i++;
            }

            if($blog->traducciones){
                foreach($blog->traducciones as $traduccion){
                    $traduccion->traducciones()->attach($blogtraducido->id,['table'=>'blogs','language_id'=>$request->language_id]);
                }
            }
            if($blog->traduccionesinversas){
                foreach($blog->traduccionesinversas as $traduccion){
                    $traduccion->traducciones()->attach($blogtraducido->id,['table'=>'blogs','language_id'=>$request->language_id]);
                }
            }
            $blog->traducciones()->attach($blogtraducido->id,['table'=>'blogs','language_id'=>$request->language_id]);

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('blog.index')->with('success','Blog Traducido Correctamente!');
    }

    public function destroy(Request $request)
    {
        $blog= Blog::findOrFail($request->id_blog_2);
        if($blog->estado=="1"){
            $blog->estado= '0';
            $blog->save();
            return redirect()->back()->with('success','Estado de Blog Cambiado Correctamente.');
        }else{
            $blog->estado= '1';
            $blog->save();
            return redirect()->back()->with('success','Estado de Blog Cambiado Correctamente.');
        }
    }
}
