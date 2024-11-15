<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;


class ImagenGaleriaNosotrosEdit extends Component
{
    use WithFileUploads;

    public $imagenes=[];
    public $imagenesanteriores=[];


    public function mount($imagenesanteriores)
    {
        $this->imagenesanteriores=$imagenesanteriores;
    }

    public function eliminarfotos($i){
        unset($this->imagenesanteriores[$i]);
    }
    public function render()
    {
        return view('livewire.imagen-galeria-nosotros-edit');
    }
}
