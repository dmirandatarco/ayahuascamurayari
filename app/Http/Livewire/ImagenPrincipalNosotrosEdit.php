<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ImagenPrincipalNosotrosEdit extends Component
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
        return view('livewire.imagen-principal-nosotros-edit');
    }
}
