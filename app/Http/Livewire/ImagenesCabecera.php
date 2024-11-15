<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;


class ImagenesCabecera extends Component
{
    use WithFileUploads;

    public $imagenes=[];

    public function render()
    {
        return view('livewire.imagenes-cabecera');
    }
}
