<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Cabecera as ModelCabecera;
use App\Models\Language;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use DB;

use App\Models\Cabecera;

use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;


class CabeceraTraducir extends Component
{
    use WithFileUploads;
    public $cont4;
    public $cont5=0;
    public $cabecera;
    public $lang;
    public $url_link;
    public $url_link2;
    public $imagenes;
    public $imagenes2;
    public $video;
    public $tipo;
    public $nombre;
    public $cabeceratraducido;
    public $galeria;
    public $cont41;

    public function render()
    {
        return view('livewire.cabecera-traducir');
    }
    public function mount(Cabecera $cabecera, $lang)
    {
        $this->cabeceratraducido = $cabecera;
        $idioma=Language::find($lang);
        $this->tipo     = $cabecera->tipo == 1 ?  1 : 0;
        $this->nombre   = $cabecera->nombre.'-'.($idioma->abreviatura);
        $this->galeria   = $cabecera->images;
        $this->cont4 = count($cabecera->images);
        $this->cont41 = count($cabecera->images);
        foreach($cabecera->images as $i => $image)
        {
            $this->url_link[$i] =$image['url_link'];
            $this->imagenes[$i] =$image['nombre']; ;
        }
    }
    public function register()
    {
        try
        {
            $this->validate([
                'nombre' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('cabeceras')->ignore(null, 'nombre')
                ],
                // Otras reglas de validación
            ]);
            $idioma=Language::find($this->lang);
            $cabecera = new ModelCabecera();
            $cabecera->nombre = $this->nombre;
            $cabecera->user_id = \Auth::user()->id;

            $cabecera->language_id = $idioma->id;
            $cabecera->tipo = $this->tipo ? '1' : '0' ;


            if($cabecera->tipo == '0')
            {
                $cabecera->video = $this->video;
                if ($this->video) {
                    $nombreVideo = $idioma->abreviatura.'-'.Str::slug($this->nombre).'.' . $this->video->getClientOriginalExtension();
                    $rutaVideo = $this->video->storeAs('img/cabecera', $nombreVideo);
                    $extensionesValidas = ['mp4', 'avi', 'mov', 'mkv']; // Lista de extensiones válidas
                    $extensionArchivo = $this->video->getClientOriginalExtension();
                    if (in_array($extensionArchivo, $extensionesValidas)) {
                        $cabecera->video = $nombreVideo;
                    } else {
                    }
                } else {
                    $cabecera->video = 'sin_video.mp4'; // Otra extensión válida, si es necesario
                }
            }

            DB::beginTransaction();
            $cabecera->save();
            $contimg=0;
            while($contimg < $this->cont4)
            {
                if ($this->imagenes[$contimg]) {
                    $nombreimagenfinal = str_replace(env('URL_WEB') . '/storage/img/cabecera/', '', $this->imagenes[$contimg]);
                    list($nombre,$extension ) = explode(".", $nombreimagenfinal);
                    $nombreImagen3 = $idioma->abreviatura.'-'.Str::slug($this->cabeceratraducido->nombre).'-'.$idioma->abreviatura.$contimg. '.webp' ;
                    Storage::copy('img/cabecera/'.$this->cabeceratraducido->images[$contimg]->nombre, 'img/cabecera/'.$nombreImagen3);
                    $cabecera->images()->create(['nombre'=>$nombreImagen3],['url_link'=>$this->url_link]);
                }
                $contimg++;
            }
            $contimg2=0;
            while($contimg2 < $this->cont5)
            {
                $image=new Image();
                if ($this->imagenes2[$contimg2]) {
                    $nombreImagen3 = $idioma->abreviatura.'-'.Str::slug($this->nombre).$contimg2+$contimg. '.webp';
                    $rutaImagen3 = $this->imagenes2[$contimg2]->storeAs('img/cabecera/', $nombreImagen3);
                    Image::make('storage/'.$rutaImagen3)->fit(1600, 1200, function ($constraint) {
                        $constraint->upsize();
                    })->encode('webp')
                    ->save('storage/'.$rutaImagen3);
                    $cabecera->images()->create(['nombre'=>$nombreImagen3],['url_link'=>$this->url_link2]);
                }
                $contimg2++;
            }

            //TRADUCCIONES
            if($this->cabeceratraducido->traducciones){
                foreach($this->cabeceratraducido->traducciones as $traduccion){
                    $traduccion->traducciones()->attach($cabecera->id,['table'=>'cabeceras','language_id'=>$this->lang]);
                }
            }
            if($this->cabeceratraducido->traduccionesinversas){
                foreach($this->cabeceratraducido->traduccionesinversas as $traduccion){
                    $traduccion->traducciones()->attach($cabecera->id,['table'=>'cabeceras','language_id'=>$this->lang]);
                }
            }
            $this->cabeceratraducido->traducciones()->attach($cabecera->id,['table'=>'cabeceras','language_id'=>$this->lang]);
            DB::commit();
            }
            catch(Exception $e)
            {
                return back()->withErrors(['error' => 'Hubo un error en el registro: ' . $e->getMessage()]);
            }
            return redirect()->route('cabecera.index')
                ->with('success', 'Cabecera Agregado Correctamente.');

    }
    public function aumentarGaleria()
    {
        $this->cont4++;
    }
    public function aumentarGaleria2()
    {

        $this->cont5++;
    }

    public function reducirGaleria($i)
    {
        array_splice($this->url_link,$i,1);
        array_splice($this->imagenes,$i,1);
        $this->cont4--;
    }
    public function reducirGaleria2($j)
    {
        if($this->url_link2)
        {
            array_splice($this->url_link2,$j,1);
        }
        $this->cont5--;
    }



}


