<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ImagenPrincipal extends Component
{
    use WithFileUploads;

    public $imagenprincipal;

    public function render()
    {
        return view('livewire.imagen-principal');
    }
}
