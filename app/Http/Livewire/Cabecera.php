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
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;



class Cabecera extends Component
{
    use WithFileUploads;

    public $tipo=0;
    public $nombre;
    public $url_link;
    public $imagenes;
    public $video;
    public $cont4=0;
    public $languageid = 1;

    public function render()
    {
        return view('livewire.cabecera');
    }
    public function aumentarDocumentos()
    {
        $this->cont4++;
    }

    public function reducirDocumentos()
    {
        $this->cont4--;
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
            $idioma=Language::find($this->languageid);
            $cabecera = new ModelCabecera();
            $cabecera->nombre = $this->nombre;
            $cabecera->user_id = \Auth::user()->id;
            $cabecera->video = $this->video;
            if(!$this->tipo == '1')
            {
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

            $cabecera->language_id = $idioma->id;
            $cabecera->tipo = $this->tipo;
            $cabecera->save();
            DB::beginTransaction();
            $contimg=0;
            while($contimg < $this->cont4)
            {
                $image=new Image();
                if ($this->imagenes[$contimg]) {
                    if ($this->imagenes[$contimg]->getClientOriginalExtension() == 'heic' || $this->imagenes[$contimg]->getClientOriginalExtension() == 'HEIC') {
                        // Realizar la conversión a .jpg y guardar en la misma ruta que FileManager
                        $fileManagerPath = public_path('storage/img/cabecera/');
                        $nombreimg=$idioma->abreviatura.'-'.Str::slug($this->nombre).$contimg.'.jpg';
                        \Maestroerror\HeicToJpg::convert($this->imagenes[$contimg])->saveAs($fileManagerPath . $nombreimg);
                        $rutaImagen3='img/cabecera/'.$nombreimg;        
                    } else {
                        $nombreImagen3 = $idioma->abreviatura.'-'.Str::slug($this->nombre).$contimg. '.' . $this->imagenes[$contimg]->getClientOriginalExtension();
                        $rutaImagen3 = $this->imagenes[$contimg]->storeAs('img/cabecera/', $nombreImagen3);
                    }
                    
                    Image::make('storage/'.$rutaImagen3)->fit(1600, 1200, function ($constraint) {
                        $constraint->upsize();
                    })->save('storage/'.$rutaImagen3,null,'jpg');
                    $cabecera->images()->create(['nombre'=>$nombreImagen3],['url_link'=>$this->url_link]);
                }
                $contimg++;
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
}
