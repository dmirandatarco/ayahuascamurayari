<?php

namespace App\Http\Livewire;

use App\Models\Detalle;
use App\Models\Proveedor;
use Livewire\Component;

class LiquidacionIngreso extends Component
{
    public $idAgencia;
    public $agencias;
    public $fecha;
    public $observacion;
    public $detalles;
    public $cantidadshow=0;
    public $cantidadnoshow=0;
    public $totalliquidacion=0;
    public $totalagenciasoles=0;
    public $totalagenciadolares=0;

    public function mount()
    {
        $this->fecha=date('Y-m-d');
        $this->agencias=Proveedor::whereRelation('servicio','nombre','AGENCIA')->get();
    }

    public function updatedfecha($value)
    {
        $detalles=Detalle::whereRelation('reserva','tipo',2)->whereRelation('reserva','proveedor_id',$this->idAgencia)->where('fecha_viaje','<=',$value)->where('pago',0)->get();
        $this->detalles=$detalles;
        $this->cantidadshow=$this->detalles->where('estado',3)->sum('cantidad');
        $this->cantidadnoshow=$this->detalles->where('estado',2)->sum('cantidad');

        $this->totalliquidacion=0;
        $this->totalagenciasoles=0;
        $this->totalagenciadolares=0;

        foreach($detalles as $detalle)
        {
            $this->totalliquidacion=$this->totalliquidacion + ($detalle->cantidad*$detalle->precio);
            if($detalle->reserva->proveedors[0]->moneda_id==1){
                $this->totalagenciasoles=$this->totalagenciasoles + $detalle->reserva->proveedors[0]->saldo;
            }else{
                $this->totalagenciadolares=$this->totalagenciadolares + $detalle->reserva->proveedors[0]->saldo;
            }
        }
    }

    public function updatedidAgencia($value)
    {
        $detalles=Detalle::whereRelation('reserva','tipo',2)->whereRelation('reserva','proveedor_id',$value)->where('fecha_viaje','<=',$this->fecha)->where('pago',0)->get();
        $this->detalles=$detalles;
        $this->cantidadshow=$this->detalles->where('estado',3)->sum('cantidad');
        $this->cantidadnoshow=$this->detalles->where('estado',2)->sum('cantidad');

        $this->totalliquidacion=0;
        $this->totalagenciasoles=0;
        $this->totalagenciadolares=0;

        foreach($detalles as $detalle)
        {
            $this->totalliquidacion=$this->totalliquidacion + ($detalle->cantidad*$detalle->precio);
            if($detalle->reserva->totales[0]->moneda_id==1){
                $this->totalagenciasoles=$this->totalagenciasoles + $detalle->reserva->totales[0]->saldo;
            }else{
                $this->totalagenciadolares=$this->totalagenciadolares + $detalle->reserva->totales[0]->saldo;
            }
        }
    }

    public function remove($i)
    {
        if($this->detalles[$i]->estado==2){
            $this->cantidadnoshow=$this->cantidadnoshow-$this->detalles[$i]->cantidad;
        }else{
            $this->cantidadshow=$this->cantidadshow-$this->detalles[$i]->cantidad;
        }
        $this->totalliquidacion=$this->totalliquidacion-($this->detalles[$i]->cantidad*$this->detalles[$i]->precio);
        if($this->detalles[$i]->reserva->totales[0]->moneda_id==1)
        {
            $this->totalagenciasoles=$this->totalagenciasoles-$this->detalles[$i]->reserva->totales[0]->saldo;
        }else{
            $this->totalagenciadolares=$this->totalagenciadolares-$this->detalles[$i]->reserva->totales[0]->saldo;
        }
        unset($this->detalles[$i]);
    }

    public function render()
    {
        return view('livewire.liquidacion-ingreso');
    }
}
