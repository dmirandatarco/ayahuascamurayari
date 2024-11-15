<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Itinerario extends Component
{
    public $cont = 0;
    public $titulo;
    public $descipcionItineario;
    public $contTotal = 0;

    public function mount($itinerarios = [])
    {
        if($itinerarios){
            $this->cont = count($itinerarios);
            $this->contTotal = count($itinerarios);
            foreach($itinerarios as $i => $itinerario){
                $this->titulo[$i] = $itinerario->titulo;
                $this->descipcionItineario[$i] = $itinerario->descripcion;
            }
        }
    }

    public function aumentar()
    {
        $this->cont++;
        $this->emit('Aumentar',$this->cont-1);
    }

    public function reducir()
    {
        $this->cont--;
    }

    public function render()
    {
        return view('livewire.itinerario');
    }
}
