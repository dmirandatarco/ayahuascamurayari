<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:ticket.index')->only('index');
        $this->middleware('can:ticket.edit')->only('update');
        $this->middleware('can:ticket.create')->only('store');
        $this->middleware('can:ticket.destroy')->only('destroy');
    }

    public function index()
    {
        $tickets=Proveedor::whereRelation('servicio','nombre','TICKETS')->get();
        $i=0;
        return view('pages.proveedor.ticket',compact('tickets','i'));
    }

    public function store(ProveedorRequest $request)
    {        
        if($request->tipoform=="crear"){
            Proveedor::create($request->all());
            return redirect()->route('ticket.index')->with('success', 'Tickets Creado Correctamente.');
        }else{
            $ticket= Proveedor::findOrFail($request->id_proveedor);
            $ticket->update($request->all());
            return redirect()->back()->with('success','Tickets Modificado Correctamente.');
        }
        
    }
    
    public function update(Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        $ticket= Proveedor::findOrFail($request->id_proveedor_2);
        if($ticket->estado=="1"){
            $ticket->estado= '0';
            $ticket->save();
            return redirect()->back()->with('success','Estado de Tickets Cambiado Correctamente.');
        }else{
            $ticket->estado= '1';
            $ticket->save();
            return redirect()->back()->with('success','Estado de Tickets Cambiado Correctamente.');
        }
    }
}
