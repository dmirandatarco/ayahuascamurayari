<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ImagenPrincipalEdit extends Component
{
    use WithFileUploads;

    public $imagenprincipal;
    public $imagen;
    
    public function mount($imagen)
    {
        $this->imagen=$imagen;
    }

    public function render()
    {
        return view('livewire.imagen-principal-edit');
    }
}
