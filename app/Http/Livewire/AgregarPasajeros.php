<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Pais;
use App\Models\Pasajero;
use App\Models\Reserva;
use DB;
use Carbon\Carbon;
use Livewire\WithFileUploads;

class AgregarPasajeros extends Component
{
    use WithFileUploads;
    public $reserva;

    public $paises;
    public $pasajeros;

    public $idPasajero;
    public $celular;
    public $email;
    public $pais_id;
    public $tipo_documento;
    public $num_documento;

    public $cont=0;
    public $idPasajero2;
    public $celular2;
    public $email2;
    public $pais_id2;
    public $tipo_documento2;
    public $num_documento2;

    public $rutapdf;

    public function mount(Reserva $reserva)
    {
        $this->reserva=$reserva;
        $this->paises=Pais::all();
        $this->pasajeros=Pasajero::all();
        $this->idPasajero=$reserva->pasajero->nombre;
        $this->celular=$reserva->pasajero->celular;
        $this->email=$reserva->pasajero->email;
        $this->pais_id=$reserva->pasajero->pais_id;
        $this->tipo_documento=$reserva->pasajero->tipo_documento;
        $this->num_documento=$reserva->pasajero->num_documento;

        $this->cont=count($reserva->pasajeros);

        foreach($reserva->pasajeros as $i => $detalle){
            $this->idPasajero2[$i] = $detalle->nombre;
            $this->celular2[$i] = $detalle->celular;
            $this->email2[$i] = $detalle->email;
            $this->pais_id2[$i] = $detalle->pais_id;
            $this->tipo_documento2[$i] = $detalle->tipo_documento;
            $this->num_documento2[$i] = $detalle->num_documento;
        }

        if($reserva->pdf!=""){
            $this->rutapdf=$reserva->pdf->rutapdf;
        }
    }

    public function updatingidPasajero($nombre)
    {
        $pasajero=Pasajero::where('nombre','=',$nombre)->first();
        if($pasajero == ""){
            $this->celular="";
            $this->email="";
            $this->pais_id="";
            $this->tipo_documento="";
            $this->num_documento="";
            $this->emit('sinEncontrar');
        }else{
            $this->celular=$pasajero->celular;
            $this->email=$pasajero->email;
            $this->pais_id=$pasajero->pais_id;
            $this->tipo_documento=$pasajero->tipo_documento;
            $this->num_documento=$pasajero->num_documento;
            $this->emit('Encontrar',$pasajero->pais_id);
        }
    }

    public function aumentar()
    {
        $this->idPasajero2[$this->cont]=0;
        $this->celular2[$this->cont]="";
        $this->email2[$this->cont]="";
        $this->pais_id2[$this->cont]="";
        $this->tipo_documento2[$this->cont]="";
        $this->num_documento2[$this->cont]="";
        $this->cont++;
        $this->emit('aumentarPasajero',$this->cont-1);
    }

    public function reducir()
    {
        $this->cont--;
    }

    public function render()
    {
        return view('livewire.agregar-pasajeros');
    }

    public function register()
    {
        try
        {
            DB::beginTransaction();

            $this->validate([
                'idPasajero'                => 'required|max:255',
                'email'                     => 'nullable|email|max:150',
                'celular'                   => 'nullable|max:30',
                'pais_id'                   => 'required|exists:pais,id',
                'tipo_documento'            => 'nullable|max:15',
                'num_documento'             => 'nullable|max:20',
            ]);

            for($i=0;$i<$this->cont;$i++){
                $this->validate([
                    'idPasajero2.'.$i                => 'required|max:255',
                    'email2.'.$i                     => 'nullable|email|max:150',
                    'celular2.'.$i                   => 'nullable|max:30',
                    'pais_id2.'.$i                   => 'required|exists:pais,id',
                    'tipo_documento2.'.$i            => 'nullable|max:15',
                    'num_documento2.'.$i             => 'nullable|max:20',
                ]);
            }

            $mytime= Carbon::now('America/Lima');

            $cliente=Pasajero::updateOrCreate([
                'nombre' => $this->idPasajero
            ],[
                'tipo_documento' => $this->tipo_documento,
                'num_documento' => $this->num_documento,
                'email' => $this->email,
                'celular' => $this->celular,
                'pais_id' => $this->pais_id,
            ]);

            $reserva=$this->reserva->update([
                'pasajero_id' => $cliente->id,
            ]);

            $reserva=$this->reserva;
            $reserva->pasajeros()->detach();
            for($i=0;$i<$this->cont;$i++){
                $cliente2=Pasajero::updateOrCreate([
                    'nombre' => $this->idPasajero2[$i]
                ],[
                    'tipo_documento' => $this->tipo_documento2[$i],
                    'num_documento' => $this->num_documento2[$i],
                    'email' => $this->email2[$i],
                    'celular' => $this->celular2[$i],
                    'pais_id' => $this->pais_id2[$i],
                ]);

                $reserva->pasajeros()->attach($cliente2->id);
            }

            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }
        return redirect()->route('reserva.pasajeros',$reserva)
            ->with('success', 'Modificación Correctamente.');
    }

    public function registerpdf()
    {
        try
        {
            DB::beginTransaction();

            $this->validate([
                'rutapdf'                => 'required|mimes:pdf',
            ]);
            if($this->reserva->pdf!=""){
                $this->reserva->pdf->delete();
            }

            $subirarchivoOtros1='RESERVA-'.$this->reserva->id.'.pdf';
            $this->rutapdf->storeAs('img/pdf/',$subirarchivoOtros1);
            $this->reserva->pdf()->create([
                'rutapdf' => $subirarchivoOtros1,
            ]);


            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollBack();
        }

        return redirect()->route('reserva.pasajeros',$this->reserva)
        ->with('success', 'Modificación Correctamente.');
        
    }
}
