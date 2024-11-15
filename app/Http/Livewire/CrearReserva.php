<?php

namespace App\Http\Livewire;

use App\Models\Proveedor;
use App\Models\Medio;
use App\Models\Moneda;
use App\Models\Pais;
use App\Models\Pasajero;
use App\Models\Servicio;
use App\Models\Tour;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use DB;

class CrearReserva extends Component
{
    public $celular;
    public $paises;
    public $email;
    public $pais_id;
    public $idPasajero;
    public $pasajeros;
    public $cont=1;
    public $cantidad;
    public $fecha_viaje;
    public $precio;
    public $observacion;
    public $tour_id;
    public $hotel_id;
    public $moneda_id;
    public $ingreso;
    public $tours;
    public $hoteles;
    public $monedas;
    public $monedas2;
    public $totalsoles=0;
    public $acuentasoles;
    public $totaldolares=0;
    public $acuentadolares;

    public $cont2=0;
    public $servicio_id;
    public $precio_operacion;
    public $descripcion;
    public $servicios;
    public $totalservicios=0;
    public $cantidadsevicio;

    public $cont3=0;
    public $monedapago;
    public $cuenta_id;
    public $monto;
    public $cuentas;
    public $pagosoles=0;
    public $pagodolares=0;
    public $saldosoles=0;
    public $saldodolares=0;

    public $reservasoles=0;
    public $reservadolares=0;
    public $push=array(["id"=>"","text"=>"SELECCIONE..."]);

    public $tipoReserva=0;
    public $formaReserva=0;
    public $userId;
    public $users;

    public function mount()
    {
        $this->paises=Pais::all();
        $this->pasajeros=Pasajero::all();
        $this->monedas=Moneda::all();
        $this->tours=Tour::where('estado',1)->get();
        $this->users=User::where('estado',1)->where('id','>',1)->get();
        $this->hoteles=Proveedor::whereRelation('servicio','nombre','HOTEL')->get();
        $this->servicios=Servicio::where('nombre','!=','GUIA')->where('nombre','!=','TRANSPORTE')->where('nombre','!=','RESTAURANTE')->where('nombre','!=','AGENCIA')->get();
        $this->cantidad[0]=0;
        $this->ingreso[0]=0;
        $this->fecha_viaje[0]="";
        $this->tour_id[0]="";
        $this->hotel_id[0]="";
        $this->moneda_id[0]=1;
        $this->precio[0]=0;
        $this->observacion[0]="DESAYUNO Y ALMUERZO INCLUIDO, INGRESOS NO INCLUIDO";
    }

    public function updatedtipoReserva()
    {
        for($i=0;$i<$this->cont;$i++)
        {
            $this->moneda_id[$i]=1;
            $this->precio[$i]=0;
        }
        for($i=0;$i<$this->cont2;$i++)
        {
            $this->precio_operacion[$i]=0;
        }
        $this->totalsoles=0;
        $this->totaldolares=0;
        $this->reservasoles=0;
        $this->reservadolares=0;
        $this->totalservicios=0;
    }

    public function updatedtotaldolares($value)
    {
        $this->reservadolares=$value;
    }

    public function updatedtotalsoles($value)
    {
        $this->reservasoles=$value;
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

    public function updatedprecio($value,$nested)
    {
        if($this->tipoReserva!=0)
        {
            if(!$this->precio[$nested]){
                $this->precio[$nested]=0;
            }
            $this->totalsoles=0;
            $this->totaldolares=0;
            $this->reservasoles=0;
            $this->reservadolares=0;
            for($i=0;$i<$this->cont;$i++){
                if($this->moneda_id[$i]=="1"){
                    $this->totalsoles=$this->totalsoles+$this->precio[$i]*$this->cantidad[$i];
                }else{
                    $this->totaldolares=$this->totaldolares+$this->precio[$i]*$this->cantidad[$i];
                }
            }
            $this->reservasoles=$this->reservasoles+$this->totalsoles+$this->totalservicios;
            $this->reservadolares=$this->reservadolares+$this->totaldolares;
        }
    }

    public function updatedcantidad($value,$nested)
    {
        if($this->tipoReserva!=0)
        {
            if(!$this->cantidad[$nested]){
                $this->cantidad[$nested]=0;
            }
            $this->totalsoles=0;
            $this->totaldolares=0;
            $this->reservasoles=0;
            $this->reservadolares=0;
            for($i=0;$i<$this->cont;$i++){
                if($this->moneda_id[$i]=="1"){
                    $this->totalsoles=$this->totalsoles+$this->precio[$i]*$this->cantidad[$i];
                }else{
                    $this->totaldolares=$this->totaldolares+$this->precio[$i]*$this->cantidad[$i];
                }
            }
            $this->reservasoles=$this->reservasoles+$this->totalsoles+$this->totalservicios;
            $this->reservadolares=$this->reservadolares+$this->totaldolares;
        }
    }

    public function updatedmonedaId($value,$nested)
    {
        if($this->tipoReserva!=0)
        {
            $this->totalsoles=0;
            $this->totaldolares=0;
            $this->reservasoles=0;
            $this->reservadolares=0;
            for($i=0;$i<$this->cont;$i++){
                if($this->moneda_id[$i]=="1"){
                    $this->totalsoles=$this->totalsoles+$this->precio[$i]*$this->cantidad[$i];
                }else{
                    $this->totaldolares=$this->totaldolares+$this->precio[$i]*$this->cantidad[$i];
                }
            }
            $this->reservasoles=$this->reservasoles+$this->totalsoles+$this->totalservicios;
            $this->reservadolares=$this->reservadolares+$this->totaldolares;
        }
    }

    public function updatedpreciooperacion($value,$nested)
    {
        if($this->tipoReserva!=0)
        {
            if(!$this->precio_operacion[$nested]){
                $this->precio_operacion[$nested]=0;
            }
            $this->totalservicios=0;
            $this->reservasoles=0;
            for($i=0;$i<$this->cont2;$i++){
                $this->totalservicios=$this->totalservicios+$this->precio_operacion[$i];
            }
            $this->reservasoles=$this->reservasoles+$this->totalservicios+$this->totalsoles;
        }
    }

    public function updatedcantidadsevicio($value,$nested)
    {
        if($this->tipoReserva!=0)
        {
            if(!$this->cantidadsevicio[$nested]){
                $this->cantidadsevicio[$nested]=0;
            }
            $this->totalservicios=0;
            $this->reservasoles=0;
            for($i=0;$i<$this->cont2;$i++){
                $this->totalservicios=$this->totalservicios+$this->precio_operacion[$i];
            }
            $this->reservasoles=$this->reservasoles+$this->totalservicios+$this->totalsoles;
        }
    }

    public function updatedmonto($value,$nested)
    {
        if($this->reservasoles>0){
            $saldosoles=$this->reservasoles-$this->pagosoles;
        }
        if($this->reservadolares>0){
            $saldodolares=$this->reservadolares-$this->pagodolares;
        }
        if($this->monedapago[$nested]=="1"){
            $this->validate([
                'cuenta_id.'.$nested => 'required',
                'monto.'.$nested => 'required|numeric|between:0.01,'.$saldosoles,
            ]);
        }else{
            $this->validate([
                'cuenta_id.'.$nested => 'required',
                'monto.'.$nested => 'required|numeric|between:0.01,'.$saldodolares,
            ]);
        }
        $this->pagosoles=0;
        $this->pagodolares=0;
        $this->saldosoles=0;
        $this->saldodolares=0;
        for($i=0;$i<$this->cont3;$i++){
            if($this->monedapago[$i]=="1"){
                $this->pagosoles=$this->pagosoles+$this->monto[$i];
            }else{
                $this->pagodolares=$this->pagodolares+$this->monto[$i];
            }
        }
        if($this->reservasoles>0){
            $this->saldosoles=$this->reservasoles-$this->pagosoles;
        }
        if($this->reservadolares>0){
            $this->saldodolares=$this->reservadolares-$this->pagodolares;
        }
    }

    public function updatedmonedapago($value,$nested)
    {
        $this->cuentas=Medio::select('id','nombre as text')->whereRelation('moneda','id','=',$value)->get();
        $this->push=collect($this->push);
        $datos=$this->push->concat($this->cuentas);
        $this->emit('aumentarPagos',$nested,$datos);
    }

    public function aumentar()
    {
        $this->cantidad[$this->cont]=0;
        $this->ingreso[$this->cont]=0;
        $this->fecha_viaje[$this->cont]="";
        $this->tour_id[$this->cont]="";
        $this->hotel_id[$this->cont]="";
        $this->moneda_id[$this->cont]=1;
        $this->precio[$this->cont]=0;
        $this->observacion[$this->cont]="DESAYUNO Y ALMUERZO INCLUIDO, INGRESOS NO INCLUIDO";
        $this->cont++;
        $this->emit('aumentarTour',$this->cont-1);
        $this->emit('aumentarHotel',$this->cont-1);
    }

    public function reducir()
    {
        if($this->moneda_id[$this->cont-1]=="1"){
            $this->totalsoles=$this->totalsoles-$this->precio[$this->cont-1]*$this->cantidad[$this->cont-1];
            $this->reservasoles=$this->reservasoles-$this->precio[$this->cont-1]*$this->cantidad[$this->cont-1];
        }else{
            $this->totaldolares=$this->totaldolares-$this->precio[$this->cont-1]*$this->cantidad[$this->cont-1];
            $this->reservadolares=$this->reservadolares-$this->precio[$this->cont-1]*$this->cantidad[$this->cont-1];
        }
        $this->cont--;
    }

    public function aumentarServicio()
    {
        $this->cantidadsevicio[$this->cont2]=0;
        $this->servicio_id[$this->cont2]="";
        $this->precio_operacion[$this->cont2]=0;
        $this->descripcion[$this->cont2]="";
        $this->cont2++;
        $this->emit('aumentarServicios',$this->cont2-1);
    }

    public function reducirServicio()
    {
        $this->totalservicios=$this->totalservicios-$this->precio_operacion[$this->cont2-1];
        $this->reservasoles=$this->reservasoles-$this->precio_operacion[$this->cont2-1];
        $this->cont2--;
    }

    public function aumentarPago()
    {
        if($this->reservasoles>0&&$this->reservadolares>0)
        {
            $this->monedas2=Moneda::all();
        }else{
            if($this->reservasoles>0)
            {
                $this->monedas2=Moneda::where('id',1)->get();
            }
            if($this->reservadolares>0)
            {
                $this->monedas2=Moneda::where('id',2)->get();
            }

        }

        $totalsoles=0;
        $totaldolares=0;
        $saldosoles=0;
        $saldodolares=0;
        if($this->cont3==0){
            if($this->reservasoles>0){
                $this->monedapago[$this->cont3]=1;
            }else{
                $this->monedapago[$this->cont3]=2;
            }
            $this->cuenta_id[$this->cont3]="";
            $this->monto[$this->cont3]=0;
            $this->cuentas=Medio::select('id','nombre as text')->whereRelation('moneda','id','=',$this->monedapago[$this->cont3])->get();
            $this->push=collect($this->push);
            $datos=$this->push->concat($this->cuentas);
            $this->cont3++;
            $this->emit('aumentarPagos',$this->cont3-1,$datos);
        }else{
            for($i=0;$i<$this->cont3-1;$i++){
                if($this->monedapago[$i]=="1"){
                    $totalsoles=$totalsoles+$this->monto[$i];
                }
                if($this->monedapago[$i]=="2"){
                    $totaldolares=$totaldolares+$this->monto[$i];
                }
            }
            $saldosoles=$this->reservasoles-$totalsoles;
            $saldodolares=$this->reservadolares-$totaldolares;
            if($this->monedapago[$this->cont3-1]=="1"){
                $this->validate([
                    'cuenta_id.'.$this->cont3-1 => 'required',
                    'monto.'.$this->cont3-1 => 'required|numeric|between:0,'.$saldosoles,
                ]);
            }else{
                $this->validate([
                    'cuenta_id.'.$this->cont3-1 => 'required',
                    'monto.'.$this->cont3-1 => 'required|numeric|between:0,'.$saldodolares,
                ]);
            }
        }
        if($saldosoles>0 && $saldodolares>0){
            if($this->reservasoles>0){
                $this->monedapago[$this->cont3]=1;
            }else{
                $this->monedapago[$this->cont3]=2;
            }
            $this->cuenta_id[$this->cont3]="";
            $this->monto[$this->cont3]=0;
            $this->cuentas=Medio::select('id','nombre as text')->whereRelation('moneda','id','=',$this->monedapago[$this->cont3])->get();
            $this->push=collect($this->push);
            $datos=$this->push->concat($this->cuentas);
            $this->cont3++;
            $this->emit('aumentarPagos',$this->cont3-1,$datos);
        }

    }

    public function reducirPago()
    {
        if($this->monedapago[$this->cont3-1]=="1"){
            $this->pagosoles=$this->pagosoles-$this->monto[$this->cont3-1];
        }else{
            $this->pagodolares=$this->pagodolares-$this->monto[$this->cont3-1];
        }
        $this->cont3--;
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
            ]);
            for($i=0;$i<$this->cont;$i++){
                $this->validate([
                    'cantidad.'.$i                     => 'required|numeric',
                    'ingreso.'.$i                     => 'required|numeric',
                    'fecha_viaje.'.$i                  => 'required|date',
                    'tour_id.'.$i                   => 'required|exists:tours,id',
                    'hotel_id.'.$i                   => 'required|max:150',
                    'moneda_id.'.$i                  => 'required|exists:monedas,id',
                    'precio.'.$i                   => 'required|numeric|regex:/^[\d]{0,15}(\.[\d]{1,2})?$/',
                    'observacion.'.$i                   => 'nullable',
                ]);
            }
            for($i=0;$i<$this->cont2;$i++){
                $this->validate([
                    'cantidadsevicio'           =>'required',
                    'servicio_id.'.$i                     => 'required|exists:servicios,id',
                    'descripcion.'.$i                   => 'nullable|max:250',
                ]);
            }
            for($i=0;$i<$this->cont3;$i++){
                $this->validate([
                    'monedapago.'.$i                     => 'required|exists:monedas,id',
                    'cuenta_id.'.$i                  => 'required|exists:medios,id',
                    'monto.'.$i                   => 'required|numeric|regex:/^[\d]{0,15}(\.[\d]{1,2})?$/',
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
            if(isset($this->userId) && $this->userId != "")
            {
                $user=User::find($this->userId);
            }else{
                $user=\Auth::user();
            }

            $reserva= $user->reservas()->create([
                'pasajero_id' => $cliente->id,
                'fecha' => $mytime->toDateTimeString(),
                'tipo' => $this->tipoReserva, //0 combo, 1 detallado, 2 endose in
                'privado' => $this->formaReserva,
                'confirmado' => 1,
                'observacion'=> null,
            ]);

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
                    'moneda_id' => $this->moneda_id[$i],
                    'fecha_viaje' => $this->fecha_viaje[$i],
                    'cantidad' => $this->cantidad[$i],
                    'ingreso' => $this->ingreso[$i],
                    'precio' => $this->precio[$i],
                    'observacion' => $this->observacion[$i],
                ]);
            }

            if($this->totalsoles>0){
                $reserva->totales()->create([
                    'moneda_id' => 1,
                    'acuenta' => $this->pagosoles,
                    'saldo' => $this->reservasoles - $this->pagosoles,
                    'total' => $this->reservasoles,
                ]);
            }

            if($this->totaldolares>0){
                $reserva->totales()->create([
                    'moneda_id' => 2,
                    'acuenta' => $this->pagodolares,
                    'saldo' => $this->reservadolares - $this->pagodolares,
                    'total' => $this->reservadolares,
                ]);
            }

            for($i=0;$i<$this->cont2;$i++){
                $reserva->servicios()->attach($this->servicio_id[$i],["cantidad"=>$this->cantidadsevicio[$i],"precio_operacion" => 0,"precio_venta" => $this->precio_operacion[$i],"descripcion" => $this->descripcion[$i]]);
            }

            for($i=0;$i<$this->cont3;$i++){

                $reserva->pagos()->create([
                    'user_id' => $user->id,
                    'moneda_id' => $this->monedapago[$i],
                    'medio_id' => $this->cuenta_id[$i],
                    'fecha' => $mytime->toDateTimeString(),
                    'monto' => $this->monto[$i],
                ]);
            }

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('reserva.index')
            ->with('success', 'Reserva Agregado Correctamente.');
    }

    public function render()
    {
        return view('livewire.crear-reserva');
    }
}
