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

class EditarEndoseOut extends Component
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
    public $agencia_id;
    public $precio;

    public $operar;
    public $detalles2;

    public function mount(Operar $operar)
    {
        $this->tours=Tour::where('estado',1)->get();
        $this->agencias=Proveedor::whereRelation('servicio','nombre','AGENCIA')->get();
        $this->operar=$operar;
        $this->idTour=$operar->tour_id;
        $this->fechaviaje=$operar->fecha;
        $this->agencia_id=$operar->proveedors[0]->id;
        $this->precio=$operar->proveedors[0]->pivot->monto / $operar->cantidad;
        $this->detalles=$operar->detallesoperar;
        $this->detalles2=Detalle::where('tour_id',$this->idTour)->where('fecha_viaje',$this->fechaviaje)->where('estado',1)->get();
        $this->cantidadpasajeros=$this->detalles->sum('detalle.cantidad')+$this->detalles2->sum('cantidad');
    }

    public function remove($i)
    {
        $this->cantidadpasajeros=$this->cantidadpasajeros-$this->detalles[$i]->detalle->cantidad;
        unset($this->detalles[$i]);
    }

    public function remove2($i)
    {
        $this->cantidadpasajeros=$this->cantidadpasajeros-$this->detalles[$i]->detalle->cantidad;
        unset($this->detalles2[$i]);
    }

    public function render()
    {
        return view('livewire.editar-endose-out');
    }
}
