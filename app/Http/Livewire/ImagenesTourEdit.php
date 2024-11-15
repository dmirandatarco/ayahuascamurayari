<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ImagenesTourEdit extends Component
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
        return view('livewire.imagenes-tour-edit');
    }
}
