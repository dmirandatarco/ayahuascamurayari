<?php

namespace App\Http\Controllers;

use App\Http\Requests\TourRequest;
use App\Models\Categoria;
use App\Models\Tour;
use App\Models\Ubicacion;
use App\Models\Servicio;
use App\Models\Image as Imagen;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Http\Controllers\Controller;
use App\Models\Itinerario;
use App\Models\Language;

class TourController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:tour.index')->only('index');
        $this->middleware('can:tour.edit')->only('edit','update');
        $this->middleware('can:tour.create')->only('create','store');
        $this->middleware('can:tour.destroy')->only('destroy');
        $this->middleware('can:tour.show')->only('show');
    }

    public function index()
    {
        $tours=Tour::all();
        $i=0;
        $images=Imagen::all();
        return view('pages.tour.index',compact('tours','i','images'));
    }

    public function create()
    {
        $categorias=Categoria::where('language_id',1)->get();
        $entradas=Servicio::whereRelation('tipo','nombre','ENTRADAS')->get();
        $ubicaciones=Ubicacion::where('language_id',1)->get();
        $servicios=Servicio::where('nombre','!=','AGENCIA')->where('nombre','!=','ENTRADAS')->get();
        $idiomas=Language::where('estado',1)->get();
        return view('pages.tour.create',compact('categorias','ubicaciones','servicios','entradas','idiomas'));
    }

    public function store(TourRequest $request)
    {
        $idioma=Language::find($request->language_id);
        try
        {
            DB::beginTransaction();

            if($request->web){
                $request['web']=1;
            }else{
                $request['web']=0;
            }
            if($request->destacado){
                $request['destacado']=1;
            }else{
                $request['destacado']=0;
            }
            list($nombre,$extension ) = explode(".", $request->imagenprincipal);
            $imagenprincipal=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
            Storage::move('livewire-tmp/'.$request->imagenprincipal, 'img/tours/'.$imagenprincipal);
            $ruta='img/tours/'.$imagenprincipal;
            Image::make('storage/'.$ruta)->orientate()->fit(1600, 1200, function ($constraint) {
                $constraint->upsize();
            })->encode('webp')
            ->save('storage/'.$ruta);

            $request['imagenprincipal']=$imagenprincipal;
            $request['slug']=Str::slug($request->nombre,'-');
            $tour=Tour::create($request->all());
            if($request->hasFile('voucher'))
            {
                $nombreimg=$idioma->abreviatura.'-'.$request['slug'].'.'.$request->file('voucher')->getClientOriginalExtension();
                $request['voucher']=$nombreimg;
                $ruta=$request->voucher->storeAs('img/cotizacion/',$nombreimg);
                $tour->voucher=$nombreimg;
                $tour->save();
            }
            foreach($request->imagenes ?? [] as $i => $imagen){
                list($nombre2,$extension2 ) = explode(".", $imagen);
                $imagen12=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'-'.$i.'.webp';
                Storage::move('livewire-tmp/'.$imagen, 'img/tours/'.$imagen12);
                $ruta='img/tours/'.$imagen12;

                Image::make('storage/'.$ruta)->orientate()->fit(1600, 1200, function ($constraint) {
                    $constraint->upsize();
                })->encode('webp')
                ->save('storage/'.$ruta);
                $tour->images()->create(['nombre'=>$imagen12]);
            }
            $ubicacions=[];
            foreach($request->ubicacion_id ?? [] as $ubicacion){
                $slugubicacion=Str::slug($ubicacion,'-');
                $ubica=Ubicacion::firstOrCreate(['nombre'=> $ubicacion,'slug'=>$slugubicacion,'language_id'=>$request->language_id]);
                if(!$ubica->image){
                    $ubica->image()->create(['nombre'=>'default.jpg']);
                }
                $ubicacions[]=$ubica->id;
            }
            $tour->servicios()->sync($request->servicio_id);
            $tour->ubicaciones()->sync($ubicacions);
            if($request->titulo){
                for($i=0; $i < count($request->titulo); $i++){
                    if($request->titulo[$i]){
                        $itinerario = new Itinerario();
                        $itinerario->titulo = $request->titulo[$i];
                        $itinerario->descripcion = $request->descipcionItineario[$i];
                        $itinerario->tour_id = $tour->id;
                        $itinerario->save();
                    }
                }
            }

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('tour.index')
            ->with('success', 'Tour Agregado Correctamente.');
    }

    public function update(TourRequest $request,Tour $tour)
    {
        $idioma=Language::find($request->language_id);
        try
        {
            DB::beginTransaction();
            if($request->web){
                $request['web']=1;
            }else{
                $request['web']=0;
            }
            if($request->destacado){
                $request['destacado']=1;
            }else{
                $request['destacado']=0;
            }
            if($request->imagenprincipal!=""){
                list($nombre,$extension ) = explode(".", $request->imagenprincipal);
                $imagenprincipal=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
                Storage::move('livewire-tmp/'.$request->imagenprincipal, 'img/tours/'.$imagenprincipal);
                $ruta='img/tours/'.$imagenprincipal;
                Image::make('storage/'.$ruta)->orientate()->fit(1600, 1200, function ($constraint) {
                    $constraint->upsize();
                })->encode('webp')
                ->save('storage/'.$ruta);
                $request['imagenprincipal']=$imagenprincipal;
            }
            $request['slug']=Str::slug($request->nombre,'-');
            if($request->entrada_id){
                $entrada=Servicio::firstOrCreate(['nombre'=> $request->entrada_id,'tipo_id' => 6]);
                $request['entrada_id']=$entrada->id;
            }
            $tour->update($request->all());
            if($request->hasFile('voucher'))
            {
                if($tour->voucher != ''){
                    Storage::delete('img/cotizacion/'.$tour->voucher);
                }
                $nombreimg=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.'.$request->file('voucher')->getClientOriginalExtension();
                $request['voucher']=$nombreimg;
                $ruta=$request->voucher->storeAs('img/cotizacion/',$nombreimg);
                $tour->voucher=$nombreimg;
                $tour->save();
            }
            $tour->images()->delete();
            $tour->itinerarios()->delete();
            $imagenesanteriores=json_decode($request->imagenes2);

            $i=0;
            foreach($imagenesanteriores ?? [] as $imagen2){
                $nombreimagenfinal = str_replace(env('URL_WEB') . '/storage/img/tours/', '',  $imagen2->nombre);
                list($nombre2,$extension24 ) = explode(".", $nombreimagenfinal);
                $imagen121=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'-'.$i.'.webp';
                Storage::copy('img/tours/'.$nombreimagenfinal, 'img/tours/'.$imagen121);

                $tour->images()->create(['nombre'=>$imagen121]);
                $i++;
            }
            foreach ($request->imagenes ?? [] as $imagen) {
                list($nombre2, $extension2) = explode(".", $imagen);
                $imagen12 = $idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'-'.$i.'.webp';
                Storage::move('livewire-tmp/'.$imagen, 'img/tours/'.$imagen12);
                $ruta = 'img/tours/'.$imagen12;
                Image::make('storage/'.$ruta)->orientate()->fit(1600, 1200, function ($constraint) {
                    $constraint->upsize();
                })->encode('webp')
                ->save('storage/'.$ruta);
                $tour->images()->create(['nombre' => $imagen12]);
                $i++;
            }
            $ubicacions=[];
            foreach($request->ubicacion_id ?? [] as $ubicacion){
                $slugubicacion=Str::slug($ubicacion,'-');
                $ubica=Ubicacion::firstOrCreate(['nombre'=> $ubicacion,'slug'=>$slugubicacion,'language_id'=>$request->language_id]);
                if(!$ubica->image){
                    $ubica->image()->create(['nombre'=>'default.jpg']);
                }
                $ubicacions[]=$ubica->id;
            }
            $tour->servicios()->sync($request->servicio_id);
            $tour->ubicaciones()->sync($ubicacions);

            if($request->titulo){
                for($i=0; $i < count($request->titulo); $i++){
                    if($request->titulo[$i]){
                        $itinerario = new Itinerario();
                        $itinerario->titulo = $request->titulo[$i];
                        $itinerario->descripcion = $request->descipcionItineario[$i];
                        $itinerario->tour_id = $tour->id;
                        $itinerario->save();
                    }
                }
            }
            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('tour.index')->with('success','Tour Modificado Correctamente!');
    }

    public function destroy(Request $request)
    {
        $tour= Tour::findOrFail($request->id_tour_2);
        if($tour->estado=="1"){
            $tour->estado= '0';
            $tour->save();
            return redirect()->back()->with('success','Tour Eliminado Correctamente!');
        }else{
            $tour->estado= '1';
            $tour->save();
            return redirect()->back()->with('success','Tour Eliminado Correctamente!');
            }
    }

    public function show(Tour $tour)
    {
        return view('pages.tour.show',compact('tour'));
    }

    public function edit(Tour $tour)
    {
        $idiomas=Language::where('estado',1)->get();
        $categorias=Categoria::where('language_id',$tour->language_id)->get();
        $ubicaciones=Ubicacion::where('language_id',$tour->language_id)->get();
        $servicios=Servicio::where('nombre','!=','AGENCIA')->where('nombre','!=','ENTRADAS')->get();
        $entradas=Servicio::whereRelation('tipo','nombre','ENTRADAS')->get();
        return view('pages.tour.edit',compact('tour','categorias','ubicaciones','servicios','entradas','idiomas'));
    }

    public function traducir($lang, Tour $tour)
    {
        $categorias=Categoria::where('language_id',$lang)->get();
        $entradas=Servicio::whereRelation('tipo','nombre','ENTRADAS')->get();
        $ubicaciones=Ubicacion::where('language_id',$lang)->get();
        $servicios=Servicio::where('nombre','!=','AGENCIA')->where('nombre','!=','ENTRADAS')->get();

        return view('pages.tour.traducir',compact('categorias','ubicaciones','servicios','entradas','tour','lang'));
    }

    public function guardartraducido(TourRequest $request,Tour $tour)
    {
        $idioma=Language::find($request->language_id);
        try
        {
            DB::beginTransaction();
            if($request->web){
                $request['web']=1;
            }else{
                $request['web']=0;
            }
            if($request->destacado){
                $request['destacado']=1;
            }else{
                $request['destacado']=0;
            }
            if($request->imagenprincipal){
                list($nombre,$extension ) = explode(".", $request->imagenprincipal);
                $imagenprincipal=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
                Storage::move('livewire-tmp/'.$request->imagenprincipal, 'img/tours/'.$imagenprincipal);
                $ruta='img/tours/'.$imagenprincipal;
                Image::make('storage/'.$ruta)->orientate()->fit(1600, 1200, function ($constraint) {
                    $constraint->upsize();
                })->encode('webp')
                ->save('storage/'.$ruta);
                $request['imagenprincipal']=$imagenprincipal;
            }else{
                $nombreimagenfinal = str_replace(env('URL_WEB') . '/storage/img/tours/', '',  $tour->imagenprincipal);
                list($nombre,$extension ) = explode(".", $nombreimagenfinal);
                $imagenprincipal=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.webp';
                Storage::copy('img/tours/'.$nombreimagenfinal, 'img/tours/'.$imagenprincipal);
                $request['imagenprincipal']=$imagenprincipal;
            }

            $request['slug']=Str::slug($request->nombre,'-');
            $tourtraducido=Tour::create($request->all());
            if($request->hasFile('voucher'))
            {
                $nombreimg=$idioma->abreviatura.'-'.$request['slug'].'.'.$request->file('voucher')->getClientOriginalExtension();
                $request['voucher']=$nombreimg;
                $ruta=$request->voucher->storeAs('img/cotizacion/',$nombreimg);
                $tourtraducido->voucher=$nombreimg;
                $tourtraducido->save();
            }else{
                if($tour->voucher){
                    $nombreimagenfinal = str_replace(env('URL_WEB') . '/storage/img/tours/', '',  $tour->voucher);
                    list($nombre,$extension ) = explode(".", $nombreimagenfinal );
                    $voucher=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'.'.$extension;
                    Storage::copy('img/cotizacion/'.$nombreimagenfinal , 'img/cotizacion/'.$voucher);
                    $tourtraducido->voucher=$voucher;
                    $tourtraducido->save();
                }
            }
            $imagenesanteriores=json_decode($request->imagenes2);
            $i=1;
            foreach($imagenesanteriores ?? [] as $imagen2){
                $nombreimagenfinal = str_replace(env('URL_WEB') . '/storage/img/tours/', '',  $imagen2->nombre);
                list($nombre2,$extension24 ) = explode(".", $nombreimagenfinal);
                $imagen121=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'-'.$i.'.webp';
                Storage::copy('img/tours/'.$nombreimagenfinal, 'img/tours/'.$imagen121);
                $tourtraducido->images()->create(['nombre'=>$imagen121]);
                $i++;
            }
            foreach($request->imagenes ?? [] as $imagen){
                list($nombre2,$extension2 ) = explode(".", $imagen);
                $imagen12=$idioma->abreviatura.'-'.Str::slug($request->nombre,'-').'-'.$i.'.webp';
                Storage::move('livewire-tmp/'.$imagen, 'img/tours/'.$imagen12);
                $ruta='img/tours/'.$imagen12;
                Image::make('storage/'.$ruta)->orientate()->fit(1600, 1200, function ($constraint) {
                    $constraint->upsize();
                })->encode('webp')
                ->save('storage/'.$ruta);
                $i++;
            }
            $ubicacions=[];
            foreach($request->ubicacion_id ?? [] as $ubicacion){
                $slugubicacion=Str::slug($ubicacion,'-');
                $ubica=Ubicacion::firstOrCreate(['nombre'=> $ubicacion,'slug'=>$slugubicacion,'language_id'=>$request->language_id]);
                if(!$ubica->image){
                    $ubica->image()->create(['nombre'=>'default.jpg']);
                }
                $ubicacions[]=$ubica->id;
            }
            $tourtraducido->servicios()->sync($request->servicio_id);
            $tourtraducido->ubicaciones()->sync($ubicacions);
            if($request->titulo){
                for($i=0; $i < count($request->titulo); $i++){
                    if($request->titulo[$i]){
                        $itinerario = new Itinerario();
                        $itinerario->titulo = $request->titulo[$i];
                        $itinerario->descripcion = $request->descipcionItineario[$i];
                        $itinerario->tour_id = $tourtraducido->id;
                        $itinerario->save();
                    }
                }
            }

            if($tour->traducciones){
                foreach($tour->traducciones as $traduccion){
                    $traduccion->traducciones()->attach($tourtraducido->id,['table'=>'tours','language_id'=>$request->language_id]);
                }
            }
            if($tour->traduccionesinversas){
                foreach($tour->traduccionesinversas as $traduccion){
                    $traduccion->traducciones()->attach($tourtraducido->id,['table'=>'tours','language_id'=>$request->language_id]);
                }
            }
            $tour->traducciones()->attach($tourtraducido->id,['table'=>'tours','language_id'=>$request->language_id]);

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('tour.index')->with('success','Tour Traducido Correctamente!');
    }

    public function pdf(Tour $tour)
    {
        $pdf= \PDF::loadView('pages.pdf.pdf-tour',compact('tour'))->setPaper('a4');
        return $pdf->download($tour->nombre.'.pdf');
    }
}
