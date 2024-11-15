<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TotalCarrito extends Component
{
    protected $listeners = ['render' => 'render'];
    
    public function render()
    {
        return view('livewire.total-carrito');
    }
}
