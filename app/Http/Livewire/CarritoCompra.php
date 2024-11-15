<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CarritoCompra extends Component
{
    protected $listeners = ['render' => 'render'];
    
    public function render()
    {
        return view('livewire.carrito-compra');
    }
}
