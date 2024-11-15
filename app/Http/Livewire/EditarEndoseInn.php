<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Hotel;
use App\Models\Medio;
use App\Models\Moneda;
use App\Models\Pais;
use App\Models\Pasajero;
use App\Models\Proveedor;
use App\Models\Reserva;
use App\Models\Servicio;
use App\Models\Tour;
use App\Models\User;
use Carbon\Carbon;
use DB;

class EditarEndoseInn extends Component
{
    public $reserva;

    public $celular;
    public $paises;
    public $email;
    public $pais_id;
    public $idPasajero;
    public $pasajeros;
    public $cont=1;
    public $cantidad;
    public $ingreso;
    public $precio;
    public $fecha_viaje;
    public $observacion;
    public $tour_id;
    public $hotel_id;
    public $tours;
    public $hoteles;
    public $monedas;
    public $agencias;

    public $cont2=0;
    public $servicio_id;
    public $precio_operacion;
    public $descripcion;
    public $servicios;
    public $totalservicios=0;
    public $cantidadsevicio;

    public $moneda_id;
    public $pago=0;
    public $agencia_id;


    public function mount(Reserva $reserva)
    {
        $this->reserva=$reserva;
        $this->paises=Pais::all();
        $this->pasajeros=Pasajero::all();
        $this->tours=Tour::where('estado',1)->get();
        $this->hoteles=Proveedor::whereRelation('servicio','nombre','HOTEL')->get();
        $this->monedas=Moneda::all();
        $this->agencias=Proveedor::whereRelation('servicio','nombre','AGENCIA')->get();
        $this->servicios=Servicio::where('nombre','!=','GUIA')->where('nombre','!=','TRANSPORTE')->where('nombre','!=','RESTAURANTE')->where('nombre','!=','AGENCIA')->get();
        
        $this->idPasajero=$reserva->pasajero->nombre;
        $this->celular=$reserva->pasajero->celular;
        $this->email=$reserva->pasajero->email;
        $this->pais_id=$reserva->pasajero->pais_id;

        $this->cont=count($reserva->detalles);
        foreach($reserva->detalles as $i => $detalle){
            $this->cantidad[$i] = $detalle->cantidad;
            $this->ingreso[$i] = $detalle->ingreso;
            $this->fecha_viaje[$i] = $detalle->fecha_viaje;
            $this->precio[$i] = $detalle->precio;
            $this->observacion[$i] = $detalle->observacion;
            $this->tour_id[$i] = $detalle->tour_id;
            $this->hotel_id[$i] = $detalle->hotel->nombre;
        }

        // Llenado de campos de servicio
        $this->cont2=count($reserva->servicios);
        foreach($reserva->servicios as $i => $servicio){
            $this->cantidadsevicio[$i] = $servicio->pivot->cantidad;
            $this->servicio_id[$i] = $servicio->id;
            $this->precio_operacion[$i] = $servicio->pivot->precio_venta;
            $this->descripcion[$i] = $servicio->pivot->descripcion;
        }

        foreach($reserva->totales as $total)
        {
            $this->pago=$total->total;
            $this->moneda_id=$total->moneda_id;
        }
        $this->agencia_id=$reserva->proveedor_id;

    }

    public function updatedtourId($value,$nested)
    {
        $tour=Tour::find($value);
        $this->precio[$nested]=$tour->precio_confidencial;
    }

    public function updatingidPasajero($nombre)
    {
        $pasajero=Pasajero::where('nombre','=',$nombre)->first();
        if($pasajero == ""){
            $this->celular="";
            $this->email="";
            $this->pais_id="";
            $this->emit('sinEncontrar');
        }else{
            $this->celular=$pasajero->celular;
            $this->email=$pasajero->email;
            $this->pais_id=$pasajero->pais_id;
            $this->emit('Encontrar',$pasajero->pais_id);
        }
    }


    public function aumentar()
    {
        $this->cantidad[$this->cont]=0;
        $this->precio[$this->cont]=0;
        $this->ingreso[$this->cont]=0;
        $this->fecha_viaje[$this->cont]="";
        $this->tour_id[$this->cont]="";
        $this->hotel_id[$this->cont]="";
        $this->observacion[$this->cont]="";
        $this->cont++;
        $this->emit('aumentarTour',$this->cont-1);
        $this->emit('aumentarHotel',$this->cont-1);
    }

    public function reducir()
    {
        $this->cont--;
    }

    public function aumentarServicio()
    {
        $this->cantidadsevicio[$this->cont2]=0;
        $this->precio_operacion[$this->cont2]=0;
        $this->servicio_id[$this->cont2]="";
        $this->descripcion[$this->cont2]="";
        $this->cont2++;
        $this->emit('aumentarServicios',$this->cont2-1);
    }

    public function reducirServicio()
    {
        $this->cont2--;
    }

    public function register()
    {
        try
        {
            DB::beginTransaction();

            $this->validate([
                'idPasajero'                    => 'required|max:255',
                'email'                     => 'nullable|email|max:150',
                'celular'                   => 'nullable|max:30',
                'pais_id'                   => 'required|exists:pais,id',
                'moneda_id'                 =>'required|exists:monedas,id',
                'agencia_id'                 =>'required|exists:proveedors,id',
            ]);
            for($i=0;$i<$this->cont;$i++){
                $this->validate([
                    'cantidad.'.$i                     => 'required|numeric',
                    'precio.'.$i                     => 'required|numeric',
                    'ingreso.'.$i                     => 'required|numeric',
                    'fecha_viaje.'.$i                  => 'required|date',
                    'tour_id.'.$i                   => 'required|exists:tours,id',
                    'hotel_id.'.$i                   => 'required|max:150',
                    'observacion.'.$i                   => 'nullable',
                ]);
            }
            
            for($i=0;$i<$this->cont2;$i++){
                $this->validate([
                    'cantidadsevicio'           =>'required',
                    'precio_operacion'      => 'required',
                    'servicio_id.'.$i                     => 'required|exists:servicios,id',
                    'descripcion.'.$i                   => 'nullable|max:250',
                ]);
            }

            $mytime= Carbon::now('America/Lima');

            $cliente=Pasajero::updateOrCreate([
                'nombre' => $this->idPasajero
            ],[
                'email' => $this->email,
                'celular' => $this->celular,
                'pais_id' => $this->pais_id,
            ]);

            $user=\Auth::user();
            $reserva= $this->reserva->update([
                'pasajero_id' => $cliente->id,
                'observacion'=> null,
                'proveedor_id'=> $this->agencia_id,
            ]);
            $reserva=$this->reserva;
            $reserva->detalles()->delete();
            for($i=0;$i<$this->cont;$i++){
                $hotel=Proveedor::firstOrCreate([
                    'nombre' => $this->hotel_id[$i],
                    'servicio_id' => 1,
                    ],[
                    'precio' => 0,
                ]);
                $reserva->detalles()->create([
                    'tour_id' => $this->tour_id[$i],
                    'hotel_id' => $hotel->id,
                    'moneda_id' => 1,
                    'fecha_viaje' => $this->fecha_viaje[$i],
                    'cantidad' => $this->cantidad[$i],
                    'ingreso' => $this->ingreso[$i],
                    'precio' => $this->precio[$i],
                    'observacion' => $this->observacion[$i],
                ]);
            }
            $this->reserva->totales()->delete();
            $reserva->totales()->create([
                'moneda_id' => $this->moneda_id,
                'acuenta' => 0,
                'saldo' => $this->pago,
                'total' => $this->pago,
            ]);
            
            for($i=0;$i<$this->cont2;$i++){
                $reserva->servicios()->attach($this->servicio_id[$i],["cantidad"=>$this->cantidadsevicio[$i],"precio_operacion" => $this->precio_operacion[$i],"precio_venta" => 0,"descripcion" => $this->descripcion[$i]]);
            }

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('endoseinn.index')
            ->with('success', 'Endose Inn Editado Correctamente.');
    }

    public function render()
    {
        return view('livewire.editar-endose-inn');
    }
}
