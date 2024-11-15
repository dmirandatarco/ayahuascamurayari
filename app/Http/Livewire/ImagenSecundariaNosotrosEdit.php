<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ImagenSecundariaNosotrosEdit extends Component
{
    use WithFileUploads;
    public $imagensecundaria;
    public $imagen2;
    public function mount($imagen2)
    {
        $this->imagen2=$imagen2;
    }
    public function render()
    {
        return view('livewire.imagen-secundaria-nosotros-edit');
    }
}
