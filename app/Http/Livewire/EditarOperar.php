<?php

namespace App\Http\Livewire;

use App\Models\Detalle;
use App\Models\Operar;
use App\Models\Proveedor;
use Livewire\Component;
use App\Models\Tour;

class EditarOperar extends Component
{
    public $tours;
    public $fechaviaje;
    public $idTour;
    public $detalles;
    public $i=0;
    public $cantidadpasajeros=0;
    public $monto_dar=0;
    public $detalleId;
    public $hora;
    public $servicios;
    public $idServicio;
    public $precioServicio;
    public $nombreServicio;
    public $push=array(["id"=>"","text"=>"SELECCIONE..."]);
    public $observacion;

    public $operar;
    public $detalles2;
    public $proveedors;

    public function render()
    {
        return view('livewire.editar-operar');
    }

    public function mount(Operar $operar)
    {
        $this->tours=Tour::where('estado',1)->get();
        $this->fechaviaje=date('Y-m-d');
        $this->operar=$operar;
        $this->idTour=$operar->tour_id;
        $this->fechaviaje=$operar->fecha;
        $this->observacion=$operar->observacion;
        $this->detalles=$operar->detallesoperar;
        $this->detalles2=Detalle::where('tour_id',$this->idTour)->where('fecha_viaje',$this->fechaviaje)->where('estado',1)->get();
        $this->cantidadpasajeros=$this->detalles->sum('detalle.cantidad')+$this->detalles2->sum('cantidad');
        $this->monto_dar=$this->detalles->sum('detalle.ingreso');
        $this->emit("Sorteable");
        $this->servicios=$operar->tour->servicios;
        $mostrar=1;
        foreach($this->servicios as $servicio)
        {
            $this->nombreServicio[$servicio->id]=$servicio->nombre;
            $this->proveedors[$servicio->id]=Proveedor::select('id','nombre as text')->where('servicio_id',$servicio->id)->get();
        }
        foreach($operar->proveedors as $proveedor)
        {
            $this->idServicio[$proveedor->servicio_id]=$proveedor->id;
            $this->precioServicio[$proveedor->servicio_id]=$proveedor->pivot->monto;
        }
    }

    //FUNCIONES
    public function updatedidServicio($value,$nested)
    {
        $proveedor=Proveedor::find($value);
        $this->precioServicio[$nested]=$proveedor->precio;
    }

    public function remove($i)
    {
        $this->cantidadpasajeros=$this->cantidadpasajeros-$this->detalles[$i]->detalle->cantidad;
        $this->monto_dar=$this->monto_dar-$this->detalles[$i]->detalle->ingreso;
        unset($this->detalles[$i]);
    }

    public function remove2($i)
    {
        $this->cantidadpasajeros=$this->cantidadpasajeros-$this->detalle->cantidad;
        $this->monto_dar=$this->monto_dar-$this->detalle->ingreso;
        unset($this->detalles2[$i]);
    }

}
