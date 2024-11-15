<?php

namespace App\Http\Livewire;

use Intervention\Image\Facades\Image;
use App\Models\Moneda;
use App\Models\Servicio;
use App\Models\Tour;
use Livewire\Component;
use DB;
use carbon\Carbon;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;

class CrearPaquete extends Component
{
    use WithFileUploads;
    public $nombre;
    public $cantidad;
    public $dia;
    public $tours;
    public $tour_id;
    public $dia_tour;
    public $precio;
    public $observacion;
    public $cont = 1;

    public $cont2 = 0;
    public $cantidadservicio;
    public $precioservicio;
    public $servicio_id;
    public $servicios;

    public $moneda_id;
    public $monedas;
    public $total = 0;

    public function mount()
    {
        $this->tours = Tour::where('estado', 1)->get();
        $this->monedas = Moneda::all();
        $this->servicios = Servicio::where('nombre', '!=', 'GUIA')->where('nombre', '!=', 'TRANSPORTE')->where('nombre', '!=', 'RESTAURANTE')->where('nombre', '!=', 'ENDOSE')->get();
        $this->observacion[0] = "";
        $this->tour_id[0] = "";
        $this->dia_tour[0] = '';
        $this->precio[0] = 0;
        $this->observacion[0] = "";
    }

    public function aumentar()
    {
        $this->tour_id[$this->cont] = "";
        $this->dia_tour[$this->cont] = '';
        $this->precio[$this->cont] = 0;
        $this->observacion[$this->cont] = "";
        $this->cont++;
        $this->emit('aumentarTour', $this->cont - 1);
    }

    public function reducir()
    {
        $this->cont--;
    }

    public function aumentarServicio()
    {
        $this->cantidadservicio[$this->cont2] = 0;
        $this->servicio_id[$this->cont2] = "";
        $this->precioservicio[$this->cont2] = 0;
        $this->cont2++;
        $this->emit('aumentarServicios', $this->cont2 - 1);
    }

    public function reducirServicio()
    {
        $this->cont2--;
    }

    public function updatedprecio($value,$nested)
    {
        if(!$this->precio[$nested]){
            $this->precio[$nested]=0;
        }
        if(!$this->cantidad){
            $this->cantidad=1;
        }
        $this->total=0;
        for($i=0;$i<$this->cont;$i++){
            $this->total=$this->total + ($this->cantidad*$this->precio[$i]);
        }
        for($i=0;$i<$this->cont2;$i++){
            if(!$this->cantidadservicio[$i]){
                $this->cantidadservicio[$i]=0;
            }
            if(!$this->precioservicio[$i]){
                $this->precioservicio[$i]=0;
            }
            $this->total=$this->total + ($this->cantidadservicio*$this->precioservicio[$i]);
        }
    }

    public function updatedcantidad()
    {
        if(!$this->cantidad){
            $this->cantidad=1;
        }
        $this->total=0;
        for($i=0;$i<$this->cont;$i++){
            if(!$this->precio[$i]){
                $this->precio[$i]=0;
            }
            $this->total=$this->total + ($this->cantidad*$this->precio[$i]);
        }
        for($i=0;$i<$this->cont2;$i++){
            if(!$this->cantidadservicio[$i]){
                $this->cantidadservicio[$i]=0;
            }
            if(!$this->precioservicio[$i]){
                $this->precioservicio[$i]=0;
            }
            $this->total=$this->total + ($this->cantidadservicio*$this->precioservicio[$i]);
        }
    }

    public function updatedcantidadservicio($value,$nested)
    {
        if(!$this->cantidadservicio[$nested]){
            $this->cantidadservicio[$nested]=0;
        }
        if(!$this->precioservicio[$nested]){
            $this->precioservicio[$nested]=0;
        }

        if(!$this->cantidad){
            $this->cantidad=1;
        }

        $this->total=0;
        for($i=0;$i<$this->cont;$i++){
            if(!$this->precio[$i]){
                $this->precio[$i]=0;
            }
            $this->total=$this->total + ($this->cantidad*$this->precio[$i]);
        }
        for($i=0;$i<$this->cont2;$i++){
            $this->total=$this->total + ($this->cantidadservicio[$i]*$this->precioservicio[$i]);
        }
    }

    public function updatedprecioservicio($value,$nested)
    {
        if(!$this->cantidadservicio[$nested]){
            $this->cantidadservicio[$nested]=0;
        }
        if(!$this->precioservicio[$nested]){
            $this->precioservicio[$nested]=0;
        }

        if(!$this->cantidad){
            $this->cantidad=1;
        }

        $this->total=0;
        for($i=0;$i<$this->cont;$i++){
            if(!$this->precio[$i]){
                $this->precio[$i]=0;
            }
            $this->total=$this->total + ($this->cantidad*$this->precio[$i]);
        }
        for($i=0;$i<$this->cont2;$i++){
            $this->total=$this->total + ($this->cantidadservicio[$i]*$this->precioservicio[$i]);
        }
    }

    public function register()
    {
        try {
            DB::beginTransaction();

            $this->validate([
                'nombre'                    => 'required|max:255',
                'cantidad'                     => 'nullable|numeric',
                'dia'                   => 'nullable|numeric',
                'moneda_id'                   => 'required|exists:monedas,id',
                'total'                   => 'required|numeric',
            ]);
            for ($i = 0; $i < $this->cont; $i++) {
                $this->validate([
                    'dia_tour.' . $i                     => 'nullable',
                    'precio.' . $i                     => 'required',
                    'tour_id.' . $i                   => 'required|exists:tours,id',
                    'observacion.' . $i                   => 'nullable',
                ]);
            }
            for ($i = 0; $i < $this->cont2; $i++) {
                $this->validate([
                    'cantidadservicio'           => 'required',
                    'precioservicio' => 'required',
                    'servicio_id.' . $i                     => 'required|exists:servicios,id',
                ]);
            }

            $mytime = Carbon::now('America/Lima');


            $user = \Auth::user();

            $paquete = $user->paquetes()->create([
                'nombre'        => $this->nombre,
                'cantidad'      => $this->cantidad,
                'dia'           => $this->dia,
                'moneda_id'     => $this->moneda_id,
                'total'         => $this->total,
                'observacion'   => null,
                'web'           => 0,
                'slug'        => Str::slug($this->nombre,'-'),
                'estado'        => '1',
                'language_id'  => 1,
            ]);

            for ($i = 0; $i < $this->cont; $i++) {
                $paquete->detalles()->create([
                    'tour_id' => $this->tour_id[$i],
                    'dia' => 1,
                    'fecha' => $this->dia_tour[$i],
                    'precio' => $this->precio[$i],
                    'observacion' => $this->observacion[$i],
                ]);
            }

            for ($i = 0; $i < $this->cont2; $i++) {
                $paquete->servicios()->attach($this->servicio_id[$i], ["cantidad" => $this->cantidadservicio[$i],"precio" => $this->precioservicio[$i]]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
        return redirect()->route('paquete.lista')
            ->with('success', 'Paquete Agregado Correctamente.');
    }

    public function render()
    {
        return view('livewire.crear-paquete');
    }
}
