<?php

namespace App\Http\Livewire;

use App\Models\Paquete;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CrearComentario extends Component
{
    public $model;
    public $tipo;
    public $nombre;
    public $email;
    public $calificacion;
    public $comentario;


    public function mount()
    {
        if($this->tipo==1){
            $this->model=Paquete::find($this->model->id);
        }else{
            $this->model=Tour::find($this->model->id);
        }

    }

    public function render()
    {
        return view('livewire.crear-comentario');
    }
    private function resetInputFields()
    {
        $this->nombre  = '';                
        $this->email = '';
        $this->calificacion = '';
        $this->comentario = '';
    }


    public function agregar()
    {
        try
        {
            DB::beginTransaction();
            $mytime= Carbon::now('America/Lima');

            $this->validate([
                'nombre' => 'required|string|max:250',
                'email' => 'required|email',
                'calificacion' => 'required|max:1500',
                'comentario' => 'required',
            ]);

            $this->model->comentarios()->create([
                'nombre' => $this->nombre,
                'email' => $this->email,
                'calificacion' => $this->calificacion,
                'comentario' => $this->comentario,
                'fecha' => $mytime->toDateTimeString(),
            ]);

            $this->resetInputFields(); 
            DB::commit();
            $this->mount();
            $this->render();
            return back()->with('success','Comentario agregado correctamente.');
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
    }
}
