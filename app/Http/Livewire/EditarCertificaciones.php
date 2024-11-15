<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Language;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Certificacio;



class EditarCertificaciones extends Component
{
    public $imagen1;
    public $imagen2;
    public $imagen3;
    public $imagen4;
    public $imagen5;
    public $imagen6;
    public $imagen7;
    public $language_id;
    public $certificado_id;
    public $titulo;
    public $subtitulo;
    public $image_1;
    public $image_2;
    public $image_3;
    public $image_4;
    public $image_5;
    public $image_6;
    public $image_7;

    use WithFileUploads;

    public function render()
    {
        return view('livewire.editar-certificaciones');
    }
    public function mount(Certificacio $certificacio)
    {
        // dd($certificacio);
        $this->language_id  = $certificacio->language_id;
        $this->certificado_id  = $certificacio->id;
        $this->titulo       = $certificacio->titulo;
        $this->subtitulo    = $certificacio->subtitulo;
        $this->image_1      = $certificacio->image_1;
        $this->image_2      = $certificacio->image_2;
        $this->image_3      = $certificacio->image_3;
        $this->image_4      = $certificacio->image_4;
        $this->image_5      = $certificacio->image_5;
        $this->image_6      = $certificacio->image_6;
        $this->image_7      = $certificacio->image_7;
    }
    public function register(){
        $idioma=Language::find($this->language_id);
        $certificacio = Certificacio::find($this->certificado_id);

        if($this->imagen1){
            $nombreimg1=$idioma->abreviatura.'-principal-'.Str::slug($this->titulo,'-').'-1.webp';
            $ruta=$this->imagen1->storeAs('img/certificados',$nombreimg1);
            Image::make('storage/'.$ruta)->fit(1600, null, function ($constraint) {
                $constraint->upsize();
            })->save('storage/'.$ruta);
        }

        if($this->imagen2){
            $nombreimg2=$idioma->abreviatura.'-principal-'.Str::slug($this->titulo,'-').'.-2.webp';
            $ruta=$this->imagen2->storeAs('img/certificados',$nombreimg2);
            Image::make('storage/'.$ruta)->fit(1600, null, function ($constraint) {
                $constraint->upsize();
            })->save('storage/'.$ruta);
        }

        if($this->imagen3){
            $nombreimg3=$idioma->abreviatura.'-principal-'.Str::slug($this->titulo,'-').'.-3.webp';
            $ruta=$this->imagen3->storeAs('img/certificados',$nombreimg3);
            Image::make('storage/'.$ruta)->fit(1600, null, function ($constraint) {
                $constraint->upsize();
            })->save('storage/'.$ruta);
        }

        if($this->imagen4){
            $nombreimg4=$idioma->abreviatura.'-principal-'.Str::slug($this->titulo,'-').'.-4.webp';
            $ruta=$this->imagen4->storeAs('img/certificados',$nombreimg4);
            Image::make('storage/'.$ruta)->fit(1600, null, function ($constraint) {
                $constraint->upsize();
            })->save('storage/'.$ruta);
        }

        if($this->imagen5){
            $nombreimg5=$idioma->abreviatura.'-principal-'.Str::slug($this->titulo,'-').'.-5.webp';
            $ruta=$this->imagen5->storeAs('img/certificados',$nombreimg5);
            Image::make('storage/'.$ruta)->fit(1600, null, function ($constraint) {
                $constraint->upsize();
            })->save('storage/'.$ruta);
        }

        if($this->imagen6){
            $nombreimg6=$idioma->abreviatura.'-principal-'.Str::slug($this->titulo,'-').'.-6.webp';
            $ruta=$this->imagen6->storeAs('img/certificados',$nombreimg6);
            Image::make('storage/'.$ruta)->fit(1600, null, function ($constraint) {
                $constraint->upsize();
            })->save('storage/'.$ruta);
        }

        if($this->imagen7){
            $nombreimg7=$idioma->abreviatura.'-principal-'.Str::slug($this->titulo,'-').'.-7.webp';
            $ruta=$this->imagen7->storeAs('img/certificados',$nombreimg7);
            Image::make('storage/'.$ruta)->fit(1600, null, function ($constraint) {
                $constraint->upsize();
            })->save('storage/'.$ruta);
        }

        $certificacio=Certificacio::find($this->certificado_id);
        $certificacio->update(
            [
            'user_id'             => \Auth::user()->id,
            'language_id'         => 1,
            'image_1'     => isset($nombreimg1) ? $nombreimg1 : str_replace(env('URL_WEB') . '/storage/img/certificados/', '', $certificacio->image_1),
            'image_2'     => isset($nombreimg2) ? $nombreimg2 : str_replace(env('URL_WEB') . '/storage/img/certificados/', '', $certificacio->image_2),
            'image_3'     => isset($nombreimg3) ? $nombreimg3 : str_replace(env('URL_WEB') . '/storage/img/certificados/', '', $certificacio->image_3),
            'image_4'     => isset($nombreimg4) ? $nombreimg4 : str_replace(env('URL_WEB') . '/storage/img/certificados/', '', $certificacio->image_4),
            'image_5'     => isset($nombreimg5) ? $nombreimg5 : str_replace(env('URL_WEB') . '/storage/img/certificados/', '', $certificacio->image_5),
            'image_6'     => isset($nombreimg6) ? $nombreimg6 : str_replace(env('URL_WEB') . '/storage/img/certificados/', '', $certificacio->image_6),
            'image_7'     => isset($nombreimg7) ? $nombreimg7 : str_replace(env('URL_WEB') . '/storage/img/certificados/', '', $certificacio->image_7),

            'titulo'              => $this->titulo,
            'subtitulo'           => $this->subtitulo,
            'estado'              => 1,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Certificados Editado Correctamente.');
    }
}
