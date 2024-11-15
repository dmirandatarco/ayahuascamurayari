<?php

namespace App\Http\Controllers;;

use App\Models\Detalle;
use App\Models\Image;
use App\Models\Reserva;
use App\Models\Tour;
use Illuminate\Http\Request;
use DB;
use PDF;
use App\Http\Controllers\Controller;

class ReservaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:reserva.index')->only('index');
        $this->middleware('can:reserva.edit')->only('edit','update');
        $this->middleware('can:reserva.create')->only('create','store');
        $this->middleware('can:reserva.destroy')->only('destroy');
        $this->middleware('can:reserva.ver')->only('ver');
        $this->middleware('can:reserva.ticket')->only('pdfticket');
        $this->middleware('can:reserva.seguimiento')->only('seguimiento');
        $this->middleware('can:reserva.pasajeros')->only('pasajeros');
    }

    public function index(Request $request)
    {
        $reservas=Reserva::whereDate('fecha','=',date('Y-m-d'))->where('tipo','!=','2')->where('confirmado',1)->orderBy('id','desc')->get();
        $i=0;
        return view('pages.reserva.index',compact('reservas','i'));
    }

    public function create()
    {
        $imagenes=Image::all();
        return view('pages.reserva.create',compact('imagenes'));
    }

    public function destroy(Request $request)
    {
        $reserva= Reserva::findOrFail($request->id_reserva_2);
        if($reserva->estado=="1"){
            $reserva->estado= '0';
            $reserva->save();
            foreach($reserva->detalles as $detalle){
                $detalle->estado=0;
                $detalle->save();
            }
            return redirect()->back()->with('success','Reserva Anulado Correctamente');
        }else{
            $reserva->estado= '1';
            $reserva->save();
            foreach($reserva->detalles as $detalle){
                $detalle->estado=1;
                $detalle->save();
            }
            return redirect()->back()->with('success','Reserva Cambiado de Estado Correctamente');
        }
    }

    public function ver(Reserva $reserva)
    {
        $subtotal=$reserva->detalles()->select(DB::raw('SUM(precio*cantidad) as cantidad'),'moneda_id')->groupBy('moneda_id')->get();
        $subtotalservicios=$reserva->servicios()->sum('precio_venta');
        $pagos=$reserva->pagos()->select(DB::raw('SUM(monto) as cantidad'),'moneda_id')->groupBy('moneda_id')->get();
        return view('pages.reserva.show',compact('reserva','subtotal','subtotalservicios','pagos'));
    }

    public function edit(Reserva $reserva)
    {
        return view('pages.reserva.edit',compact('reserva'));
    }

    public function pdfticket(Reserva $reserva)
    { 
        $facebook="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNC4wLjIsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgdmlld0JveD0iMCAwIDIyLjcgMjIuNyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjIuNyAyMi43OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8c3R5bGUgdHlwZT0idGV4dC9jc3MiPg0KCS5zdDB7ZmlsbDojMzdBRDcwO30NCgkuc3Qxe2ZpbGw6I0ZGRkZGRjt9DQo8L3N0eWxlPg0KPGc+DQoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTAsMTYuN1Y1LjlDMCwyLjcsMi43LDAsNS45LDBoMTAuOGMzLjMsMCw1LjksMi43LDUuOSw1LjlsMCwxMC44YzAsMy4zLTIuNyw1LjktNS45LDUuOWgtMy42bC0xLjktMC41DQoJCWwtMS42LDAuNWwtMy42LDBDMi43LDIyLjcsMCwyMCwwLDE2Ljd6Ii8+DQoJPGc+DQoJCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik0xNS44LDE1bDAuNS0zLjNoLTMuMVY5LjZjMC0wLjksMC40LTEuOCwxLjgtMS44aDEuNFY1YzAsMC0xLjMtMC4yLTIuNS0wLjJjLTIuNiwwLTQuMywxLjYtNC4zLDQuNHYyLjVINi43DQoJCQlWMTVoMi45djcuN2gzLjVWMTVIMTUuOHoiLz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg==";
        $instagram="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNC4wLjIsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgdmlld0JveD0iMCAwIDIyLjcgMjIuNyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjIuNyAyMi43OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8c3R5bGUgdHlwZT0idGV4dC9jc3MiPg0KCS5zdDB7ZmlsbDojMzdBRDcwO30NCgkuc3Qxe2ZpbGw6I0ZGRkZGRjt9DQo8L3N0eWxlPg0KPGc+DQoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTAsMTVWNy42QzAsMy40LDMuNCwwLDcuNiwwTDE1LDBjNC4yLDAsNy42LDMuNCw3LjYsNy42VjE1YzAsNC4yLTMuNCw3LjYtNy42LDcuNmwtNy40LDANCgkJQzMuNCwyMi43LDAsMTkuMiwwLDE1eiIvPg0KCTxnPg0KCQk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNMTQuOSw3LjFjLTAuNCwwLTAuOCwwLjMtMC44LDAuOGMwLDAuNCwwLjMsMC44LDAuOCwwLjhjMC40LDAsMC44LTAuMywwLjgtMC44QzE1LjYsNy40LDE1LjMsNy4xLDE0LjksNy4xeiINCgkJCS8+DQoJCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik0xMS40LDguMWMtMS44LDAtMy4zLDEuNS0zLjMsMy4zYzAsMS44LDEuNSwzLjMsMy4zLDMuM2MxLjgsMCwzLjMtMS41LDMuMy0zLjNDMTQuNyw5LjUsMTMuMiw4LjEsMTEuNCw4LjF6DQoJCQkgTTExLjQsMTMuNGMtMS4yLDAtMi4xLTAuOS0yLjEtMi4xczAuOS0yLjEsMi4xLTIuMWMxLjIsMCwyLjEsMC45LDIuMSwyLjFTMTIuNSwxMy40LDExLjQsMTMuNHoiLz4NCgkJPHBhdGggY2xhc3M9InN0MSIgZD0iTTE0LDE4SDguN2MtMi4yLDAtNC0xLjgtNC00VjguN2MwLTIuMiwxLjgtNCw0LTRIMTRjMi4yLDAsNCwxLjgsNCw0VjE0QzE4LDE2LjIsMTYuMiwxOCwxNCwxOHogTTguNyw1LjkNCgkJCWMtMS41LDAtMi43LDEuMi0yLjcsMi43VjE0YzAsMS41LDEuMiwyLjcsMi43LDIuN0gxNGMxLjUsMCwyLjctMS4yLDIuNy0yLjdWOC43YzAtMS41LTEuMi0yLjctMi43LTIuN0g4Ljd6Ii8+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=";
        $tiktok="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNC4wLjIsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgdmlld0JveD0iMCAwIDIyLjcgMjIuNyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjIuNyAyMi43OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8c3R5bGUgdHlwZT0idGV4dC9jc3MiPg0KCS5zdDB7ZmlsbDojMzdBRDcwO30NCgkuc3Qxe2ZpbGw6I0ZGRkZGRjt9DQo8L3N0eWxlPg0KPGc+DQoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTAsMTVWNy42QzAsMy40LDMuNCwwLDcuNiwwSDE1YzQuMiwwLDcuNiwzLjQsNy42LDcuNmwwLDcuNGMwLDQuMi0zLjQsNy42LTcuNiw3LjZsLTcuNCwwDQoJCUMzLjQsMjIuNywwLDE5LjIsMCwxNXoiLz4NCgk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNMTcuMiwxMGMtMC4xLDAtMC4yLDAtMC4zLDBjLTEuMywwLTIuNS0wLjYtMy4yLTEuN3Y1LjhjMCwyLjQtMS45LDQuMy00LjMsNC4zYy0yLjQsMC00LjMtMS45LTQuMy00LjMNCgkJYzAtMi40LDEuOS00LjMsNC4zLTQuM2wwLDBjMC4xLDAsMC4yLDAsMC4zLDBWMTJjLTAuMSwwLTAuMiwwLTAuMywwYy0xLjIsMC0yLjIsMS0yLjIsMi4yczEsMi4yLDIuMiwyLjJjMS4yLDAsMi4zLTEsMi4zLTIuMg0KCQlsMC05LjloMmMwLjIsMS44LDEuNywzLjIsMy41LDMuNEwxNy4yLDEwIi8+DQo8L2c+DQo8L3N2Zz4NCg==";
        $whatsapp="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNC4wLjIsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgdmlld0JveD0iMCAwIDIyLjcgMjIuNyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjIuNyAyMi43OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8c3R5bGUgdHlwZT0idGV4dC9jc3MiPg0KCS5zdDB7ZmlsbDojMzdBRDcwO30NCgkuc3Qxe2ZpbGw6I0ZGRkZGRjt9DQo8L3N0eWxlPg0KPGc+DQoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTAsMTVWNy42QzAsMy40LDMuNCwwLDcuNiwwTDE1LDBjNC4yLDAsNy42LDMuNCw3LjYsNy42VjE1YzAsNC4yLTMuNCw3LjYtNy42LDcuNkg3LjZDMy40LDIyLjcsMCwxOS4yLDAsMTV6Ig0KCQkvPg0KCTxnPg0KCQk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNMy4yLDE5LjVjMC4yLTAuNiwwLjQtMS4xLDAuNS0xLjZjMC4zLTAuOCwwLjUtMS42LDAuOC0yLjRjMC4xLTAuMSwwLTAuMywwLTAuNGMtMS45LTMuMy0xLjItNy40LDEuNy05LjkNCgkJCWMxLjctMS41LDMuNy0yLjEsNi0yYzMuNCwwLjMsNi4yLDIuNiw3LjEsNS45YzAuNywyLjksMCw1LjUtMi4yLDcuNmMtMi41LDIuNC02LjIsMi45LTkuMywxLjRjLTAuMS0wLjEtMC4yLTAuMS0wLjQsMA0KCQkJYy0xLjMsMC40LTIuNiwwLjgtMy45LDEuM0MzLjQsMTkuNCwzLjMsMTkuNCwzLjIsMTkuNXogTTUuMiwxNy41QzYsMTcuMyw2LjgsMTcsNy42LDE2LjhjMC4xLDAsMC4yLDAsMC4zLDANCgkJCWMxLjcsMSwzLjUsMS4zLDUuNCwwLjdjMy40LTAuOSw1LjUtNC40LDQuOC03LjhjLTAuOC0zLjYtNC4yLTUuOS03LjktNS4yYy00LjYsMC44LTYuOSw2LTQuNSwxMGMwLjMsMC40LDAuMywwLjcsMC4xLDEuMg0KCQkJQzUuNiwxNi4zLDUuNCwxNi45LDUuMiwxNy41eiIvPg0KCQk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNNy42LDkuMWMwLTAuNCwwLjItMC45LDAuNy0xLjNjMC4zLTAuMywwLjctMC4zLDEtMC4zYzAuMSwwLDAuMiwwLjEsMC4zLDAuMmMwLjIsMC41LDAuNSwxLjEsMC43LDEuNg0KCQkJYzAsMC4xLDAsMC4yLDAsMC4zYy0wLjEsMC4yLTAuMywwLjQtMC41LDAuNmMtMC4xLDAuMi0wLjIsMC4zLTAuMSwwLjVjMC42LDEuMSwxLjUsMS44LDIuNywyLjNjMC4yLDAuMSwwLjMsMCwwLjQtMC4xDQoJCQljMC4yLTAuMiwwLjQtMC41LDAuNi0wLjdjMC4xLTAuMSwwLjItMC4yLDAuNC0wLjFjMC42LDAuMywxLjEsMC41LDEuNywwLjhjMC4xLDAsMC4xLDAuMiwwLjEsMC4zYzAsMC45LTAuNSwxLjMtMS40LDEuNg0KCQkJYy0wLjQsMC4xLTAuOCwwLTEuMi0wLjFjLTIuMi0wLjYtMy43LTEuOS00LjgtMy44QzcuOCwxMC40LDcuNiw5LjksNy42LDkuMXoiLz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg==";
        $ubicacion="data:image/png;base64,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";
        $pdf= \PDF::loadView('pages.pdf.ticketpdf',compact('reserva','facebook','instagram','tiktok','whatsapp','ubicacion'))->setPaper('a4');
        return $pdf->download($reserva->pasajero->nombre.'-'.date("d-m-Y",strtotime($reserva->fecha)).'.pdf');
    }

    public function seguimiento(Request $request)
    {
        $valuetour=$request->tour;
        $fecha=$request->fecha;
        $detalles=Detalle::when($valuetour,function($query) use ($valuetour){
            $query->where('tour_id',$valuetour);
        })->when($fecha,function($query) use ($fecha){
            $query->where('fecha_viaje',$fecha);
        })->whereRelation('reserva','confirmado','1')->orderBy('fecha_viaje','asc')->get();
        $tours=Tour::where('estado',1)->get();
        if($request->fecha== '' && $request->tour == ''){
            $detalles=Detalle::whereDate('fecha_viaje','=',date('Y-m-d'))->whereRelation('reserva','confirmado','1')->get();
        }
        // $reservas=Reserva::whereDate('fecha','=',date('Y-m-d'))->get();
        $i=0;
        return view('pages.reserva.seguimiento',compact('detalles','i','tours','valuetour','fecha'));
    }

    public function pasajeros(Reserva $reserva)
    {
        return view('pages.reserva.pasajeros',compact('reserva'));
    }

    public function notificar(Reserva $reserva)
    {
        Mail::to($reserva->pasajero?->email)->send(new VoucherMailable($reserva));
        return redirect()->back()->with('success','Reserva Notificada Correctamente');
    }
}