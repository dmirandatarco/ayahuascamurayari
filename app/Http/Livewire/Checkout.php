<?php

namespace App\Http\Livewire;

use App\Models\Medio;
use App\Models\Pago;
use App\Models\Pais;
use App\Models\Paquete;
use App\Models\Pasajero;
use App\Models\Proveedor;
use App\Models\Reserva;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use DB;

class Checkout extends Component
{
    public $num_formulario=1;
    public $totalSteps = 3;
    public $pax=0;
    public $name;
    public $doc;
    public $nume_doc;
    public $pais;
    public $name_titular;
    public $email_titular;
    public $phone_titular;
    public $paises;

    public $formToken;
    public $reserva;
    public $pago;

    public function mount()
    {
        $this->paises=Pais::all();
    }

    public function render()
    {
        $this->pax=0;
        foreach(Cart::content() as $item){
            if($item->qty >= $this->pax){
                $this->pax=$item->qty;
            }
        }
        return view('livewire.checkout');
    }

    public function aumentarStep()
    {
        if($this->num_formulario ==2){
            $this->segundoFormulario();
        }
        $this->num_formulario++;
        if($this->num_formulario > $this->totalSteps){
            $this->num_formulario= $this->totalSteps;
        }
    }
    public function disminuirStep()
    {
        $this->num_formulario--;
        if($this->num_formulario < 1){
            $this->num_formulario= 1;
        }
    }

    public function segundoFormulario()
    {
        $this->validate([
            'name_titular'                    => 'required|max:255',
            'phone_titular'                     => 'required|max:30',
            'email_titular'                   => 'required|email|max:150',
        ]);
        for($i=0;$i<$this->pax;$i++){
            $this->validate([
                'name.'.$i                     => 'required|max:255',
                'doc.'.$i                     => 'required|max:15',
                'nume_doc.'.$i                  => 'required|max:20',
                'pais.'.$i                   => 'required|exists:pais,id',
            ]);
        }
    }

    public function delete($rowId){
        Cart::remove($rowId);
        $this->render();
        $this->emit('render');
    }

    public function izipay()
    {
        $mytime= Carbon::now('America/Lima');

        $aux=0;

        for($i=0;$i<$this->pax;$i++)
        {
            if($this->name[$i]==$this->name_titular){
                $aux=$i;
            }
        }

        $cliente=Pasajero::updateOrCreate([
            'nombre' => $this->name_titular,
        ],[
            'celular' => $this->phone_titular,
            'tipo_documento' => $this->doc[$aux],
            'num_documento' => $this->nume_doc[$aux],
            'email' => $this->email_titular,
            'pais_id' => $this->pais[$aux],
        ]);

        $user=User::first();

        $reserva=Reserva::updateOrCreate([
            'user_id' => $user->id,
            'pasajero_id' => $cliente->id,
            'tipo' => 1,
            'privado' => 1,
            'confirmado' => 0,
            'observacion'=> null,
        ],[
            'fecha' => $mytime->toDateTimeString(),
        ]);

        $reserva->pasajeros()->detach();

        for($i=0; $i < $this->pax ; $i++){
            $cliente2=Pasajero::updateOrCreate([
                'nombre' => $this->name[$i],
            ],[
                'tipo_documento' => $this->doc[$i],
                'num_documento' => $this->nume_doc[$i],
                'pais_id' => $this->pais[$i],
            ]);
            $reserva->pasajeros()->attach($cliente2->id);
        }

        $hotel=Proveedor::firstOrCreate([
            'nombre' => 'POR CONFIRMAR',
            'servicio_id' => 1,
            ],[
            'precio' => 0,
        ]);

        $reserva->detalles()->delete();
        
        foreach(Cart::content() as $item){
            if($item->options->tipo==0){
                $reserva->detalles()->create([
                    'tour_id' => $item->id,
                    'hotel_id' => $hotel->id,
                    'moneda_id' => 2,
                    'fecha_viaje' => $item->options->fecha,
                    'cantidad' => $item->qty,
                    'ingreso' => 0,
                    'precio' => $item->price,
                    'observacion' => "RESERVA WEB",
                ]);
            }else{
                $paquete=Paquete::find($item->id);
                foreach($paquete->detalles as $detalle){
                    $reserva->detalles()->create([
                        'tour_id' => $detalle->tour_id,
                        'hotel_id' => $hotel->id,
                        'moneda_id' => 2,
                        'fecha_viaje' => $item->options->fecha,
                        'cantidad' => $item->qty,
                        'ingreso' => 0,
                        'precio' => $item->price,
                        'observacion' => "RESERVA WEB",
                    ]);
                }
            }
        }
        
        $reserva->totales()->delete();

        $reserva->totales()->create([
            'moneda_id' => 2,
            'acuenta' => 0,
            'saldo' => Cart::subTotal(),
            'total' => Cart::subTotal(),
        ]);
        
        $data=$reserva->id;
        Cart::destroy();
        return redirect()->route('web.reserva.izipay',$data);
    }

    public function autorizar(){
        $authorizacion=base64_encode('58211388:testpassword_5XaqW3unjbzaQtvQrpixbtljiUr4RtZaFGNLYaLRccCOy');
        $token=Http::withHeaders([
            'Authorization' => 'Basic '. $authorizacion,
            'Accept' => 'application/json'
        ])
        ->post('https://api.micuentaweb.pe/api-payment/V4/Charge/CreatePayment',[
            'amount'=> 50000,
            'currency' => 'USD',
            'orderId' => 1,
            'customer' => [
                'reference' => 124,
                'email' => 'dmirandatarco@gmail.com',
                'billingDetails' => [
                    'firstName' => 'DAVID MIRANDA',
                ],                                                    
            ]
        ])->object();

        $this->formToken=  $token->answer->formToken;
        $this->render();
    }

    public function pagarpaytoperu()
    {
        try
        {
            DB::beginTransaction();

            $mytime= Carbon::now('America/Lima');

            $aux=0;

            for($i=0;$i<$this->pax;$i++)
            {
                if($this->name[$i]==$this->name_titular){
                    $aux=$i;
                }
            }

            $cliente=Pasajero::updateOrCreate([
                'nombre' => $this->name_titular,
            ],[
                'celular' => $this->phone_titular,
                'tipo_documento' => $this->doc[$aux],
                'num_documento' => $this->nume_doc[$aux],
                'email' => $this->email_titular,
                'pais_id' => $this->pais[$aux],
            ]);

            $user=User::first();

            $reserva=Reserva::updateOrCreate([
                'user_id' => $user->id,
                'pasajero_id' => $cliente->id,
                'tipo' => 1,
                'privado' => 1,
                'confirmado' => 0,
                'observacion'=> null,
            ],[
                'fecha' => $mytime->toDateTimeString(),
            ]);

            $reserva->pasajeros()->detach();

            for($i=0; $i < $this->pax ; $i++){
                $cliente2=Pasajero::updateOrCreate([
                    'nombre' => $this->name[$i],
                ],[
                    'tipo_documento' => $this->doc[$i],
                    'num_documento' => $this->nume_doc[$i],
                    'pais_id' => $this->pais[$i],
                ]);
                $reserva->pasajeros()->attach($cliente2->id);
            }

            $hotel=Proveedor::firstOrCreate([
                'nombre' => 'POR CONFIRMAR',
                'servicio_id' => 1,
                ],[
                'precio' => 0,
            ]);

            $reserva->detalles()->delete();
            
            foreach(Cart::content() as $item){
                if($item->options->tipo==0){
                    $reserva->detalles()->create([
                        'tour_id' => $item->id,
                        'hotel_id' => $hotel->id,
                        'moneda_id' => 2,
                        'fecha_viaje' => $item->options->fecha,
                        'cantidad' => $item->qty,
                        'ingreso' => 0,
                        'precio' => $item->price,
                        'observacion' => "RESERVA WEB",
                    ]);
                }else{
                    $paquete=Paquete::find($item->id);
                    foreach($paquete->detalles as $detalle){
                        $reserva->detalles()->create([
                            'tour_id' => $detalle->tour_id,
                            'hotel_id' => $hotel->id,
                            'moneda_id' => 2,
                            'fecha_viaje' => $item->options->fecha,
                            'cantidad' => $item->qty,
                            'ingreso' => 0,
                            'precio' => $item->price,
                            'observacion' => "RESERVA WEB",
                        ]);
                    }
                }
            }
            
            $reserva->totales()->delete();

            $reserva->totales()->create([
                'moneda_id' => 2,
                'acuenta' => 0,
                'saldo' => str_replace(',', '', Cart::subTotal()),
                'total' => str_replace(',', '', Cart::subTotal()),
            ]);
            
            $data=$reserva->id;

            $medio = Medio::where('nombre','LIKE','%DAY PAY TO PERU%')->first();

            $pago = Pago::create([
                'user_id' => $user->id,
                'moneda_id' => 2,
                'medio_id' => $medio->id,
                'reserva_id' => $reserva->id,
                'fecha' => $mytime->toDateTimeString(),
                'monto' => str_replace(',', '', Cart::subTotal())/2,
                'estado' => 0
            ]);

            $this->pago=$pago;
            $this->reserva=$reserva;
            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        $this->enviarformulario();
    }

    public function enviarformulario()
    {
        Cart::destroy();
        $this->emit('enviar-formulario');
    }
}