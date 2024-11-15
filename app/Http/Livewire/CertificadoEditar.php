<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Language;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Certificacio;
use App\Models\DetalleCertificado;

class CertificadoEditar extends Component
{
    use WithFileUploads;

    public $images;
    public $galeria;
    public $language_id;
    public $certificado_id;
    public $titulo;
    public $subtitulo;
    public $imagenesgaleria=[];
    public $urlanterior;
    public $urlabriranterior;
    public $url;
    public $urlabrir;
    public $cont;
    
    public function render()
    {
        return view('livewire.certificado-editar');
    }

    public function aumentar()
    {
        $this->cont ++;
    }

    public function reducir($i)
    {
        unset($this->url[$i]);
        $this->url = array_values($this->url);
        unset($this->urlabrir[$i]);
        $this->urlabrir = array_values($this->urlabrir);
        $this->cont --;
    }

    public function eliminarfotos($i){
        unset($this->galeria[$i]);
    }

    public function mount(Certificacio $certificado)
    {
        $this->language_id  = $certificado->language_id;
        $this->certificado_id  = $certificado->id;
        $this->titulo       = $certificado->titulo;
        $this->subtitulo    = $certificado->subtitulo;
        $this->cont = count($certificado->detalles);
        foreach($certificado->detalles as $i => $detalle)
        {
            $this->urlanterior[$i] = $detalle->url;
            $this->urlabriranterior[$i] = $detalle->urlabrir;
        }
    }
    public function register(){
        $idioma=Language::find($this->language_id);
        $certificado=Certificacio::find($this->certificado_id);
        $certificado->update(
            [
            'user_id'             => \Auth::user()->id,
            'language_id'         => $idioma->id,
            'titulo'              => $this->titulo,
            'subtitulo'           => $this->subtitulo,
            'estado'              => 1,
        ]);
        $certificado->detalles()->delete();
        for($i=0; $i < $this->cont; $i++)
        {
            $detalle = new DetalleCertificado();
            $detalle->certificacio_id = $this->certificado_id;
            if(isset($this->url[$i])){
                $nombreimg1=$idioma->abreviatura.'-principal-'.Str::slug($this->titulo,'-').$i.'.webp';
                $ruta=$this->url[$i]->storeAs('img/certificados',$nombreimg1);
                Image::make('storage/'.$ruta)->encode('webp')
                ->save('storage/'.$ruta);
                $detalle->url = $nombreimg1;
            }else{
                $nombreimagenfinal = str_replace(env('URL_WEB') . '/storage/img/certificados/', '', $this->urlanterior[$i]);
                $nombreimg1=$idioma->abreviatura.'-principal-'.Str::slug($this->titulo,'-').$i.'.webp';
                Storage::copy('img/certificados/'.$nombreimagenfinal, 'img/certificados/'.$nombreimg1);
                $detalle->url =  $nombreimg1;
            }
            if(isset($this->urlabrir[$i])){
                $nombreimg1=$idioma->abreviatura.'-secundario-'.Str::slug($this->titulo,'-').$i.'.webp';
                $ruta=$this->urlabrir[$i]->storeAs('img/certificados',$nombreimg1);
                Image::make('storage/'.$ruta)->encode('webp')
                ->save('storage/'.$ruta);
                $detalle->urlabrir = $nombreimg1;
            }else{
                $nombreimagenfinal = str_replace(env('URL_WEB') . '/storage/img/certificados/', '', $this->urlabriranterior[$i]);
                $nombreimg1=$idioma->abreviatura.'-secundario-'.Str::slug($this->titulo,'-').$i.'.webp';
                Storage::copy('img/certificados/'.$nombreimagenfinal, 'img/certificados/'.$nombreimg1);
                $detalle->urlabrir = $nombreimg1;
            }
            $detalle->save();
        }

        return redirect()->route('certificados.index')
            ->with('success', 'Certificados Editado Correctamente.');
    }
}
