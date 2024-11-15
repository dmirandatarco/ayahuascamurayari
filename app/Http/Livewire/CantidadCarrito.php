<?php

namespace App\Http\Livewire;

use App\Models\Pais;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class CantidadCarrito extends Component
{
    public $pax=0;
    public $paises;
    
    protected $listeners = ['render' => 'render'];

    public function mount()
    {
        $this->paises = Pais::all();
    }

    public function render()
    {
        $this->pax=0;
        foreach(Cart::content() as $item){
            if($item->qty >= $this->pax){
                $this->pax=$item->qty;
            }
        }
        return view('livewire.cantidad-carrito');
    }
}
