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

class PaqueteWebCrear extends Component
{
    use WithFileUploads;
    public $nombre;
    public $cantidad;
    public $dia;
    public $tours;
    public $tour_id;
    public $dia_tour;
    public $observacion;
    public $cont = 1;
    public $titulo2;
    public $descripcion;
    public $imgprincipal;
    public $incluye;
    public $noincluye;
    public $tipo;
    public $altura;
    public $web=1;
    public $recomendaciones;
    public $video;
    public $mapa;

    public $cont2 = 0;
    public $cantidadsevicio;
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
    }

    public function aumentar()
    {
        $this->tour_id[$this->cont] = "";
        $this->dia_tour[$this->cont] = 0;
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
        $this->cantidadsevicio[$this->cont2] = 0;
        $this->servicio_id[$this->cont2] = "";
        $this->cont2++;
        $this->emit('aumentarServicios', $this->cont2 - 1);
    }

    public function reducirServicio()
    {
        $this->cont2--;
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
                    'dia_tour.' . $i                     => 'required|numeric',
                    'tour_id.' . $i                   => 'required|exists:tours,id',
                    'observacion.' . $i                   => 'nullable',
                ]);
            }
            for ($i = 0; $i < $this->cont2; $i++) {
                $this->validate([
                    'cantidadsevicio'           => 'required',
                    'servicio_id.' . $i                     => 'required|exists:servicios,id',
                ]);
            }

            $mytime = Carbon::now('America/Lima');


            $user = \Auth::user();


            $rutaImagen = 'public/img/paquetes/default.png';

            if ($this->imgprincipal) {
                $nombreImagen = Str::slug($this->nombre) . '.' . $this->imgprincipal->getClientOriginalExtension();

                $rutaImagen = $this->imgprincipal->storeAs('img/paquetes', $nombreImagen);

                Image::make('storage/' . $rutaImagen)->resize(1600, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('storage/' . $rutaImagen, null, 'jpg');
            }

            if ($this->mapa) {
                $nombreImagen1 = Str::slug($this->nombre) . '.' . $this->mapa->getClientOriginalExtension();

                $rutaImagen1 = $this->mapa->storeAs('img/mapas', $nombreImagen1);

                Image::make('storage/' . $rutaImagen1)->resize(1600, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('storage/' . $rutaImagen1, null, 'jpg');
            }


            $paquete = $user->paquetes()->create([
                'nombre'        => $this->nombre,
                'cantidad'      => $this->cantidad,
                'dia'           => $this->dia,
                'moneda_id'     => $this->moneda_id,
                'total'         => $this->total,
                'observacion'   => null,
                'titulo2'       => $this->titulo2,
                'descripcion'   => $this->descripcion,
                'imgprincipal'  => $nombreImagen,
                'incluye'       => $this->incluye,
                'noincluye'     => $this->noincluye,
                'altura'        => $this->altura,
                'web'           => 1,
                'recomendacion' => $this->recomendaciones,
                'video'         => $this->video,
                'mapa'          => $nombreImagen1,
                'estado'        => '1',
                'slug'          => Str::slug($this->nombre,'-'),
                'language_id'   => 1,
                'user_id'       => \Auth::user()->id,
            ]);

            for ($i = 0; $i < $this->cont; $i++) {
                $paquete->detalles()->create([
                    'tour_id' => $this->tour_id[$i],
                    'dia' => $this->dia_tour[$i],
                    'observacion' => $this->observacion[$i],
                ]);
            }

            for ($i = 0; $i < $this->cont2; $i++) {
                $paquete->servicios()->attach($this->servicio_id[$i], ["cantidad" => $this->cantidadsevicio[$i]]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
        return redirect()->route('paqueteweb.index')
            ->with('success', 'Paquete Agregado Correctamente.');
    }

    public function render()
    {
        return view('livewire.paquete-web-crear');
    }
}
