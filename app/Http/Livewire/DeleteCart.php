<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class DeleteCart extends Component
{
    public function delete($rowId){
        Cart::remove($rowId);
        $this->render();
        $this->emit('render');
    }

    public function render()
    {
        return view('livewire.delete-cart');
    }
}
