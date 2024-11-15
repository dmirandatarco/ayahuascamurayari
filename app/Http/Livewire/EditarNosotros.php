<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Nosotro;
use App\Models\Language;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Http\Controllers\Controller;


class EditarNosotros extends Component
{
    use WithFileUploads;
    public $image_principal;
    public $image_secundaria;
    public $titulo;
    public $subtitulo;
    public $descripcion;
    public $descripcion1;
    public $descripcion2;
    public $descripcion3;
    public $galeria;
    public $nosotros;
    public $imagen2;
    public $imagen;
    public $imagenesgaleria=[];
    public $nosotros_id;
    public $language_id;

    public $num_viajes;
    public $num_clientes;
    public $num_miembros;
    public $num_reconocimientos;

    public $nosotro;

    
    public function eliminarfotos($i){
        unset($this->galeria[$i]);
    }

    public function render()
    {
        return view('livewire.editar-nosotros');
    }
    public function mount(Nosotro $nosotro)
    {
        $this->language_id = $nosotro->language_id;
        $this->nosotros_id = $nosotro->id;
        $this->nosotro  = $nosotro;
        $this->galeria = $nosotro->images;
        $this->image_principal = $nosotro->image_principal;
        $this->image_secundaria = $nosotro->image_secundaria;
        $this->titulo = $nosotro->titulo;
        $this->subtitulo = $nosotro->subtitulo;
        $this->descripcion = $nosotro->descripcion;
        $this->descripcion1 = $nosotro->descripcion1;
        $this->descripcion2 = $nosotro->descripcion2;
        $this->descripcion3 = $nosotro->descripcion3;
        $this->num_viajes   = $nosotro->num_viajes;
        $this->num_clientes = $nosotro->num_clientes;
        $this->num_miembros = $nosotro->num_miembros;
        $this->num_reconocimientos  = $nosotro->num_reconocimientos;
    }
    public function register(){
        $idioma=Language::find($this->language_id);
        $nosotros = Nosotro::find($this->nosotros_id);
        if($this->imagen){
            $nombreimg1=$idioma->abreviatura.'-principal-'.Str::slug($this->titulo,'-').'.webp';
            $ruta=$this->imagen->storeAs('img/nosotros',$nombreimg1);
            Image::make('storage/'.$ruta)->fit(1600, 1200, function ($constraint) {
                $constraint->upsize();
            })->encode('webp')
            ->save('storage/'.$ruta);
        }
        if($this->imagen2){
            $nombreimg2=$idioma->abreviatura.'-secundario-'.Str::slug($this->titulo,'-').'.webp';
            $ruta=$this->imagen2->storeAs('img/nosotros',$nombreimg2);
            Image::make('storage/'.$ruta)->fit(1600, 1200, function ($constraint) {
                $constraint->upsize();
            })->encode('webp')
            ->save('storage/'.$ruta);
        }
        $nosotro=Nosotro::find($this->nosotros_id);
        $nosotro->update(
            [
            'user_id'             => \Auth::user()->id,
            'language_id'         => $this->language_id,
            'image_principal'     => isset($nombreimg1) ? $nombreimg1 : str_replace(env('URL_WEB') . '/storage/img/nosotros/', '', $nosotro->image_principal),
            'image_secundaria'    => isset($nombreimg2) ? $nombreimg2 : str_replace(env('URL_WEB') . '/storage/img/nosotros/', '', $nosotro->image_secundaria),
            'titulo'              => $this->titulo,
            'subtitulo'           => $this->subtitulo,
            'descripcion'         => $this->descripcion,
            'descripcion1'         => $this->descripcion1,
            'descripcion2'         => $this->descripcion2,
            'descripcion3'         => $this->descripcion3,
            'num_viajes'          => $this->num_viajes,
            'num_clientes'        => $this->num_clientes,
            'num_miembros'        => $this->num_miembros,
            'num_reconocimientos' => $this->num_reconocimientos,
            'estado'              => 1,
        ]);
        $i=1;
        $nosotros->images()->delete();
        foreach($this->galeria ?? [] as $imagen){
            $nombreimg2 = str_replace(env('URL_WEB') . '/storage/img/nosotros/', '', $imagen->nombre);
            $imagen121=$idioma->abreviatura.'-galeria-'.Str::slug($this->titulo,'-').'-'.$i.'.webp';
            Storage::copy('img/nosotros/'.$nombreimg2, 'img/nosotros/'.$imagen121);
            $nosotros->images()->create(['nombre'=>$imagen121]);
            $i++;
        }
        foreach($this->imagenesgaleria ?? [] as $imagen){
            $nombreimg2=$idioma->abreviatura.'-galeria-'.Str::slug($this->titulo,'-').'-'.$i.'.webp';
            $ruta=$imagen->storeAs('img/nosotros',$nombreimg2);
            Image::make('storage/'.$ruta)->fit(1600, 1200, function ($constraint) {
                $constraint->upsize();
            })->encode('webp')
            ->save('storage/'.$ruta);
            $nosotros->images()->create(['nombre'=>$nombreimg2]);
            $i++;
        }
        return redirect()->route('nosotros.index')
            ->with('success', 'Nosotros Editado Correctamente.');
    }
}
