<?php

namespace App\Http\Livewire;

use App\Models\Paquete;
use App\Models\Tour;
use Carbon\Carbon;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class FormularioWeb extends Component
{
    public $model;
    public $total;
    public $cantidad=1;
    public $fecha;
    public $tipo;

    public function mount($id,$tipo)
    {
        $this->tipo=$tipo;
        //tipo 0 = tour , 1 = paquete
        $this->fecha=Carbon::now()->format('Y-m-d');
        if($tipo==0){
            $this->model = Tour::find($id);
            $this->total = $this->cantidad * $this->model->precio;
        }else{
            $this->model = Paquete::find($id);
            $this->total = $this->cantidad * $this->model->total;
        }
    }

    public function render()
    {
        return view('livewire.formulario-web');
    }

    public function aumentar()
    {
        $this->cantidad++;
        if($this->tipo==0){
            $this->total = $this->cantidad * $this->model->precio;
        }else{
            $this->total = $this->cantidad * $this->model->total;
        }
        
    }

    public function disminuir()
    {
        if($this->cantidad>0){
            $this->cantidad--;
            if($this->tipo==0){
                $this->total = $this->cantidad * $this->model->precio;
            }else{
                $this->total = $this->cantidad * $this->model->total;
            }
        }
        
    }

    public function addItem() 
    {
        if($this->tipo==0){
            Cart::add(['id' => $this->model->id, 'name' => $this->model->nombre, 'qty' => $this->cantidad, 'price' => $this->model->precio, 'weight' => 1, 'options' => ['image' => $this->model->imagenprincipal,'fecha' => $this->fecha,'tipo'=>0]]);
            $this->emit('render');
        }else{
            Cart::add(['id' => $this->model->id, 'name' => $this->model->nombre, 'qty' => $this->cantidad, 'price' => $this->model->total, 'weight' => 1, 'options' => ['image' => $this->model->imgprincipal,'fecha' => $this->fecha,'tipo'=>1]]);
            $this->emit('render');
        }
        return redirect()->route('web.reserva.checkout')
            ->with('success', 'Paquete Agregado Correctamente.');
    }
}
