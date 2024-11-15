<?php

namespace App\Http\Livewire;
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
use Livewire\Component;

class CabeceraEditar extends Component
{
    use WithFileUploads;
    public $cont4;
    public $cont5=0;
    public $cabecera;
    public $lang;
    public $url_link;
    public $url_link2;
    public $imagenes=[];
    public $imagenes2;
    public $video;
    public $tipo;
    public $nombre;
    public $cabeceraanterior;
    public $galeria;
    public $cont41;

    public function render()
    {
        return view('livewire.cabecera-editar');
    }
    public function mount(Cabecera $cabecera)
    {
        $this->cabeceraanterior = $cabecera;
        $idioma=Language::find($this->cabecera->language_id);
        if (!$cabecera->tipo || $cabecera->tipo == '0')
        {
            $this->tipo     = 0;
        }
        else{
            $this->tipo     = 1;
        }

        $this->nombre   = $cabecera->nombre;
        $this->galeria   = $this->cabeceraanterior->images;
        $this->cont4 = count($cabecera->images);
        $this->cont41 = count($this->cabeceraanterior->images);
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
                    Rule::unique('cabeceras')->ignore($this->nombre, 'nombre')
                ],
                // Otras reglas de validación
            ]);
            $idioma=Language::find($this->cabecera->language_id);
            $cabecera = ModelCabecera::find($this->cabecera->id);
            $cabecera->nombre = $this->nombre;
            $cabecera->user_id = \Auth::user()->id;
            $cabecera->language_id = $idioma->id;
            $cabecera->tipo = $this->tipo ? '1' : '0' ;

            if($this->tipo == '0' || $this->tipo == null)
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
            foreach($this->imagenes as $imagen2){
                $cabecera->images()->delete(['nombre'=>$imagen2]);
            }
            $contimg=0;

            while($contimg < $this->cont4)
            {
                if ($this->imagenes[$contimg]) {
                    $nombreimagenfinal = str_replace(env('URL_WEB') . '/storage/img/cabecera/', '', $this->imagenes[$contimg]);
                    list($nombre,$extension ) = explode(".", $nombreimagenfinal);
                    $nombreImagen3 = $idioma->abreviatura.'-'.Str::slug($this->cabecera->nombre).'-'.$contimg. '.webp' ;
                    Storage::copy('img/cabecera/'.$nombreimagenfinal, 'img/cabecera/'.$nombreImagen3);
                    $cabecera->images()->create(['nombre'=>$nombreImagen3],['url_link'=>$this->url_link]);
                }
                $contimg++;
            }
            $contimg2=0;
            while($contimg2 < $this->cont5)
            {
                if ($this->imagenes2[$contimg2]) {
                    if ($this->imagenes2[$contimg2]->getClientOriginalExtension() == 'heic' || $this->imagenes2[$contimg2]->getClientOriginalExtension() == 'HEIC') {
                        // Realizar la conversión a .jpg y guardar en la misma ruta que FileManager
                        $fileManagerPath = public_path('storage/img/cabecera/');
                        $nombreimg=$idioma->abreviatura.'-'.Str::slug($this->nombre).$contimg2.'.webp';
                        \Maestroerror\HeicToJpg::convert($this->imagenes2[$contimg2])->saveAs($fileManagerPath . $nombreimg);
                        $rutaImagen3='img/cabecera/'.$nombreimg;        
                    } else {
                        $nombreImagen3 = $idioma->abreviatura.'-'.Str::slug($this->nombre).$contimg2. '.webp';
                        $rutaImagen3 = $this->imagenes2[$contimg2]->storeAs('img/cabecera/', $nombreImagen3);
                    }
                    Image::make('storage/'.$rutaImagen3)->fit(1600, 1200, function ($constraint) {
                        $constraint->upsize();
                    })->encode('webp')
                    ->save('storage/'.$rutaImagen3);
                    $cabecera->images()->create(['nombre'=>$nombreImagen3],['url_link'=>$this->url_link2]);
                }
                $contimg2++;
            }
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
    public function hidemedia(){

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
