<?php

namespace App\Http\Livewire;

use App\Models\OperarProveedor;
use App\Models\Proveedor;
use App\Models\Tipo;
use Livewire\Component;

class LiquidacionEgreso extends Component
{
    public $idCategoria;
    public $idProveedor;
    public $categorias;
    public $fecha;
    public $observacion;
    public $detalles;
    public $totalliquidacion=0;
    public $push=array(["id"=>"","text"=>"SELECCIONE..."]);

    public function mount()
    {
        $this->fecha=date('Y-m-d');
        $this->categorias=Tipo::where('id','!=','6')->get();
    }

    public function updatedidCategoria($value)
    {
        if($value==1){
            $proveedors=Proveedor::select('id','nombre as text')->where('servicio_id','=',$value)->where('precio','>',0)->get();
        }else{
            $proveedors=Proveedor::select('id','nombre as text')->where('servicio_id','=',$value)->get();
        }
        $this->push=collect($this->push);
        $datos=$this->push->concat($proveedors);
        $this->emit('aumentar',$datos);
        $this->detalles=[];
        $this->totalliquidacion=0;
    }

    public function updatedfecha($value)
    {
        $detalles=OperarProveedor::where('proveedor_id',$this->idProveedor)->whereRelation('operar','fecha','<=',$value)->where('estado',1)->get();
        $this->detalles=$detalles;
        $this->totalliquidacion=$detalles->sum('monto');
    }

    public function updatedidProveedor($value)
    {
        $detalles=OperarProveedor::where('proveedor_id',$value)->whereRelation('operar','fecha','<=',$this->fecha)->where('estado',1)->get();
        $this->detalles=$detalles;
        $this->totalliquidacion=$detalles->sum('monto');
    }

    public function remove($i)
    {
        $this->totalliquidacion=$this->totalliquidacion-$this->detalles[$i]->monto;
        unset($this->detalles[$i]);
    }

    public function render()
    {
        return view('livewire.liquidacion-egreso');
    }
}
