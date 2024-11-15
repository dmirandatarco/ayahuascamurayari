<?php

namespace App\Http\Livewire;


use Livewire\Component;
use Livewire\WithFileUploads;

class ImagenMapa extends Component
{
    use WithFileUploads;

    public $imagenmapa;

    public function render()
    {
        return view('livewire.imagen-mapa');
    }
}
