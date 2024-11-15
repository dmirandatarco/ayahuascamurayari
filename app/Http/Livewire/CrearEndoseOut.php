<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Detalle;
use App\Models\DetalleOperar;
use App\Models\Operar;
use App\Models\Proveedor;
use App\Models\Tour;
use DB;
use Carbon\Carbon;

class CrearEndoseOut extends Component
{
    public $tours;
    public $fechaviaje;
    public $idTour;
    public $detalles;
    public $i=0;
    public $cantidadpasajeros=0;
    public $detalleId;
    public $hora;
    public $agencias;

    public function mount()
    {
        $this->tours=Tour::where('estado',1)->get();
        $this->fechaviaje=date('Y-m-d');
        $this->agencias=Proveedor::whereRelation('servicio','nombre','AGENCIA')->get();
    }

    public function updatedidTour($value)
    {
        $this->detalles=Detalle::where('tour_id',$value)->where('fecha_viaje',$this->fechaviaje)->where('estado',1)->get();
        $this->cantidadpasajeros=$this->detalles->sum('cantidad');
        $this->emit("Sorteable");
    }

    public function updatedfechaviaje($value)
    {
        $this->detalles=Detalle::where('tour_id',$this->idTour)->where('fecha_viaje',$value)->where('estado',1)->get();
        $this->cantidadpasajeros=$this->detalles->sum('cantidad');
        $this->emit("Sorteable");
    }

    public function remove($i)
    {
        $this->cantidadpasajeros=$this->cantidadpasajeros-$this->detalles[$i]->cantidad;
        unset($this->detalles[$i]);
    }


    public function render()
    {
        return view('livewire.crear-endose-out');
    }
}
