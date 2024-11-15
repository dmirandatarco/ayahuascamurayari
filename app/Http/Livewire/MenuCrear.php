<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Menu;
use App\Models\MenuDetalle;
use Livewire\Component;
use DB;

class MenuCrear extends Component
{
    public $nombre;
    public $tipo = 1;
    public $cont = 0;
    public $categoria_id;
    public $nombredetalle;
    public $url;
    public $categorias;
    public $language_id;
    public $isEdit = 0; 
    public $menu;

    protected $listeners = ['actualizarOrden' => 'actualizarOrden'];

    public function mount($menu = null,$lenguaje = 1)
    {
        if(isset($menu))
        {
            $this->menu = $menu;
            $this->isEdit = 1;
            $this->cont = count($menu->detalles);
            $this->nombre = $menu->nombre;
            $this->tipo =  $menu->tipo;
            for($i = 0; $i < $this->cont; $i++){
                $this->categoria_id[$i] = $menu->detalles[$i]->categoria_id;
                $this->nombredetalle[$i] = $menu->detalles[$i]->nombre;
                $this->url[$i] = $menu->detalles[$i]->url;
            }
        }
        $this->language_id = $lenguaje;
        $this->categorias = Categoria::where('language_id',$lenguaje)->get();
    }
    
    public function actualizarOrden($ordenElementos)
    {
        // Crea una copia de los arrays originales para preservar los valores actuales
        $categoria_id_original = $this->categoria_id;
        $nombredetalle_original = $this->nombredetalle;
        $url_original = $this->url;

        // Recorre el array de índices reordenados
        foreach ($ordenElementos as $indiceNuevo => $indiceViejo) {
            // Usa el índice nuevo para actualizar los valores correspondientes en tus arrays de datos
            $this->categoria_id[$indiceNuevo] = $categoria_id_original[$indiceViejo] ?? null;
            $this->nombredetalle[$indiceNuevo] = $nombredetalle_original[$indiceViejo] ?? null;
            $this->url[$indiceNuevo] = $url_original[$indiceViejo] ?? null;
        }
    }


    public function aumentar()
    {
        $this->cont ++;
    }

    public function reducir()
    {
        $this->cont --;
    }

    public function guardar()
    {
        try
        {
            DB::beginTransaction();
            $this->validate([
                'nombre'                    => 'required|max:255',
                'tipo'                     => 'required',
            ]);

            if($this->isEdit == 1){
                $menu = Menu::find($this->menu->id);
                $menu->nombre = $this->nombre;
                $menu->tipo = $this->tipo;
                $menu->save();
            }else{
                $menu = Menu::create([
                    'nombre' => $this->nombre,
                    'language_id' => $this->language_id,
                    'tipo' => $this->tipo,
                ]);
            }
            $menu->detalles()->delete();
            for($i = 0; $i < $this->cont; $i++)
            {
                $detalle = MenuDetalle::create([
                    'menu_id' => $menu->id,
                    'categoria_id' => $this->categoria_id[$i] ?? null,
                    'nombre' => $this->nombredetalle[$i] ?? null,
                    'url' => $this->url[$i] ?? null,
                ]);
            }
            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('menu.index')
            ->with('success', 'Menu Guardado Correctamente.');
    }

    public function render()
    {
        return view('livewire.menu-crear');
    }
}
