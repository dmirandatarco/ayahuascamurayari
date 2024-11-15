<?php

namespace App\Http\Livewire;

use Intervention\Image\Facades\Image;
use App\Models\Moneda;
use App\Models\Servicio;
use App\Models\Tour;
use App\Models\Paquete;
use App\Models\Language;
use Livewire\Component;
use DB;
use carbon\Carbon;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PaqueteWebTraducir extends Component
{
    use WithFileUploads;

    public $paquete;
    public $nombre;
    public $titulo2;
    public $cantidad;
    public $dia;
    public $altura;
    public $imagen;
    public $imgprincipal;
    public $mapa;
    public $imagen2;
    public $video;

    public $descripcion;
    public $noincluye;
    public $recomendaciones;
    public $incluye;
    public $cont;
    public $detalles;

    //detalles Tours
    public $tour_id;
    public $dia_tour;
    public $observacion;
    public $tours;
    public $monedas;
    public $servicios;


    //servicios
    public $cantidadsevicio;
    public $servicio_id;
    public $serviciosant;
    public $total;
    public $moneda_id;
    public $lang;


    public function mount(Paquete $paquete,$lang)
    {
        $this->tours = Tour::where('estado', 1)->where('language_id',$lang)->get();
        $this->monedas = Moneda::all();
        $this->servicios = Servicio::where('nombre', '!=', 'GUIA')->where('nombre', '!=', 'TRANSPORTE')->where('nombre', '!=', 'RESTAURANTE')->where('nombre', '!=', 'ENDOSE')->get();
        $this->paquete = $paquete;
        $this->nombre = $paquete->nombre;
        $this->titulo2 = $paquete->titulo2;
        $this->cantidad = $paquete->cantidad;
        $this->dia = $paquete->dia;
        $this->altura = $paquete->altura;
        $this->imgprincipal = $paquete->imgprincipal;
        $this->mapa = $paquete->mapa;


        $this->descripcion = $paquete->descripcion;
        $this->noincluye = $paquete->noincluye;
        $this->recomendaciones = $paquete->recomendacion;
        $this->incluye = $paquete->incluye;
        $this->video = $paquete->video;
        $this->detalles = $paquete->detalles;
        $this->serviciosant = $paquete->servicios;
        $this->cont = count($paquete->detalles);
        $this->cont2 = count($paquete->servicios);
        $this->cont4 = count($this->paquete->servicios);

        $this->lang =$lang;



        foreach($this->detalles as $i => $detalle)
        {

            $tourstraducidos = $detalle->tour->traduccion($lang);
            $this->tour_id[$i] =$tourstraducidos?->id;

            $this->dia_tour[$i] =$detalle['dia']; ;
            $this->observacion[$i] =$detalle['observacion'];
        }

        foreach($this->serviciosant as $i => $servicios)
        {
            $this->cantidadsevicio[$i] =$servicios['pivot']['cantidad'];
            $this->servicio_id[$i] =$servicios['pivot']['servicio_id']; ;
        }


    }

    public function aumentar()
    {
        $this->tour_id[$this->cont]=0;
        $this->dia_tour[$this->cont]=0;
        $this->observacion[$this->cont]="";
        $this->cont++;
        $this->emit('aumentarTour',$this->cont-1);

    }

    public function reducir($i)
    {
        if($this->tour_id)
        {
            array_splice($this->tour_id,$i,1);
        }
        if($this->dia_tour)
        {
            array_splice($this->dia_tour,$i,1);
        }
        if($this->observacion)
        {
            array_splice($this->observacion,$i,1);
        }
        $this->cont--;
    }
    public function aumentarServicio()
    {
        $this->cont2++;
    }
    public function reducirServicio($j)
    {
        if($this->cantidadsevicio)
        {
            array_splice($this->cantidadsevicio,$j,1);
        }
        if($this->servicio_id)
        {
            array_splice($this->servicio_id,$j,1);
        }
        $this->cont2--;
    }
    public function register()
    {
        $idioma=Language::find($this->lang);
        try {
            DB::beginTransaction();
            $this->validate([
                'nombre'                    => 'required|max:255',
                'cantidad'                     => 'nullable|numeric',
                'dia'                   => 'nullable|numeric',
                'moneda_id'                   => 'required|exists:monedas,id',
                'total'                   => 'required|numeric',
            ]);
            for ($i = 0; $i < $this->cont; $i++) {
                $this->validate([
                    'dia_tour.' . $i                     => 'required|numeric',
                    'tour_id.' . $i                   => 'required|exists:tours,id',
                    'observacion.' . $i                   => 'nullable',
                ]);
            }
            for ($i = 0; $i < $this->cont2; $i++) {
                $this->validate([
                    'cantidadsevicio'           => 'required',
                    'servicio_id.' . $i                     => 'required|exists:servicios,id',
                ]);
            }
            $mytime = Carbon::now('America/Lima');
            $user = \Auth::user();
            $rutaImagen = 'public/img/paquetes/default.png';
            if (!$this->imagen) {
                list($nombre,$extension ) = explode(".", $this->imgprincipal);
                $nombreImagen = $idioma->abreviatura.'-'.Str::slug($this->paquete->nombre).'-principal-' .'.' .$extension ;
                Storage::copy('img/\paquetes/'.$this->paquete->imgprincipal, 'img/\paquetes/'.$nombreImagen);
            }
            else {
                $nombreImagen=$idioma->abreviatura.'-principal-'.Str::slug($this->paquete->nombre).'-principal-' .'.'.$this->imagen->getClientOriginalExtension();
                $ruta=$this->imagen->storeAs('img/paquetes',$nombreImagen);
                Image::make('storage/'.$ruta)->fit(1600, 1200, function ($constraint) {
                    $constraint->upsize();
                })->save('storage/'.$ruta,null,'jpg');
            }
            if (!$this->imagen2) {
                list($nombre,$extension ) = explode(".", $this->mapa);
                $nombreImagen1 = $idioma->abreviatura.'-'.Str::slug($this->paquete->nombre).'-mapa-' .'.' .$extension ;
                Storage::copy('img/\paquetes/'.$this->paquete->mapa, 'img/\paquetes/'.$nombreImagen1);
            }
            else {

                $nombreImagen1=$idioma->abreviatura.'-mapa-'.Str::slug($this->paquete->nombre).'-mapa-' .'.'.$this->imagen2->getClientOriginalExtension();
                $ruta=$this->imagen2->storeAs('img/paquetes',$nombreImagen1);
                Image::make('storage/'.$ruta)->fit(1600, 1200, function ($constraint) {
                    $constraint->upsize();
                })->save('storage/'.$ruta,null,'jpg');
            }
            // $paquete = $user->paquetes()->where('id', $this->paquete->id)->first();
                $paquetetraducido = Paquete::create([
                    'nombre'        => $this->nombre,
                    'cantidad'      => $this->cantidad,
                    'dia'           => $this->dia,
                    'moneda_id'     => $this->moneda_id,
                    'total'         => $this->total,
                    'observacion'   => null,
                    'titulo2'       => $this->titulo2,
                    'descripcion'   => $this->descripcion,
                    'imgprincipal'  => $nombreImagen,
                    'incluye'       => $this->incluye,
                    'noincluye'     => $this->noincluye,
                    'altura'        => $this->altura,
                    'web'           => 1,
                    'recomendacion' => $this->recomendaciones,
                    'video'         => $this->video,
                    'mapa'          => $nombreImagen1,
                    'estado'        => '1',
                    'slug'          => Str::slug($this->nombre,'-'),
                    'language_id'   => $this->lang,
                    'user_id'       => \Auth::user()->id,
                ]);
            $paquetetraducido->detalles()->delete();
            for ($i = 0; $i < $this->cont; $i++) {
                $paquetetraducido->detalles()->create([
                    'tour_id' => $this->tour_id[$i],
                    'dia' => $this->dia_tour[$i],
                    'observacion' => $this->observacion[$i],
                ]);
            }

            $paquetetraducido->servicios()->detach();

            for ($i = 0; $i < $this->cont2; $i++) {
                $paquetetraducido->servicios()->attach($this->servicio_id[$i], ["cantidad" => $this->cantidadsevicio[$i]]);
            }
            //TRADUCCIONES
            if($this->paquete->traducciones){
                foreach($this->paquete->traducciones as $traduccion){
                    $traduccion->traducciones()->attach($paquetetraducido->id,['table'=>'paquetes','language_id'=>$this->lang]);
                }
            }
            if($this->paquete->traduccionesinversas){
                foreach($this->paquete->traduccionesinversas as $traduccion){
                    $traduccion->traducciones()->attach($paquetetraducido->id,['table'=>'paquetes','language_id'=>$this->lang]);
                }
            }
            $this->paquete->traducciones()->attach($paquetetraducido->id,['table'=>'paquetes','language_id'=>$this->lang]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
        return redirect()->route('paqueteweb.index')
            ->with('success', 'Paquete Traducido Correctamente.');
    }

    public function render()
    {
        return view('livewire.paquete-web-traducir');
    }
}
