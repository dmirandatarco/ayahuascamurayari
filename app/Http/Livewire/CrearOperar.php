<?php

namespace App\Http\Livewire;

use App\Models\Detalle;
use App\Models\Proveedor;
use Livewire\Component;
use App\Models\Tour;

class CrearOperar extends Component
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

    public function render()
    {
        return view('livewire.crear-operar');
    }

    public function mount()
    {
        $this->tours=Tour::where('estado',1)->get();
        $this->fechaviaje=date('Y-m-d');
    }

    //FUNCIONES
    public function updatedidTour($value)
    {
        $tour=Tour::find($value);
        $this->detalles=Detalle::where('tour_id',$value)->where('fecha_viaje',$this->fechaviaje)->where('estado',1)->get();
        $this->cantidadpasajeros=$this->detalles->sum('cantidad');
        $this->monto_dar=$this->detalles->sum('ingreso');
        $this->emit("Sorteable");
        if(isset($tour->servicios))
        {
            $this->servicios=$tour->servicios;
            $mostrar=1;
        }else{
            $this->servicios=[];
            $mostrar=0;
        }
        foreach($this->servicios as $servicio)
        {
            $this->nombreServicio[$servicio->id]=$servicio->nombre;
            $proveedors=Proveedor::select('id','nombre as text')->where('servicio_id',$servicio->id)->get();
            $this->push=collect($this->push);
            $datos=$this->push->concat($proveedors);
            $this->emit('aumentarServicio',$servicio->id,$datos,$mostrar);
        }
    }

    public function updatedfechaviaje($value)
    {
        $this->detalles=Detalle::where('tour_id',$this->idTour)->where('fecha_viaje',$value)->where('estado',1)->get();
        $this->cantidadpasajeros=$this->detalles->sum('cantidad');
        $this->monto_dar=$this->detalles->sum('ingreso');
        $this->emit("Sorteable");
    }

    public function updatedidServicio($value,$nested)
    {
        $proveedor=Proveedor::find($value);
        $this->precioServicio[$nested]=$proveedor->precio;
    }

    public function remove($i)
    {
        $this->cantidadpasajeros=$this->cantidadpasajeros-$this->detalles[$i]->cantidad;
        $this->monto_dar=$this->monto_dar-$this->detalles[$i]->ingreso;
        unset($this->detalles[$i]);
    }
}

