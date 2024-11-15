<?php

namespace App\Http\Controllers;

use App\Exports\ReservaExports;
use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    //


    public function reservas(Request $request)
    {

        $fechainicio =$request->buscarFechaInicio;
        $fechafin = $request->buscarFechaFin;
        $usuarios = User::all();
        $usuario = $request->buscarUsuario;
        $reservas = Reserva::when($request->buscarUsuario,function($query) use ($usuario){
            $query->where('user_id',$usuario);
        })->when($fechainicio,function($query) use ($fechainicio,$fechafin){
            $query->whereDate('fecha','>=',$fechainicio.' 00:00:00')
            ->whereDate('fecha','<=',$fechafin.' 23:59:59');
        })->orderBy('fecha','asc')->get();
        $total = count($reservas);

        if ($request->buscarUsuario == "" && $request->buscarFechaInicio == "" && $request->buscarFechaFin == "") {
            $total = 0;
            $reservas = [];
        }
        

        return view('pages.reportes.reservas',compact('fechainicio','fechafin','reservas','usuarios','usuario','total'));
    }

    public function reservaspdf($fechainicio, $fechafin, $usuario2)
    {
        $reservas = Reserva::where('estado', 'LIKE', '%%');
        if ($fechainicio != '0') {
            $reservas = $reservas->whereDate('fecha','>=',$fechainicio.' 00:00:00')
            ->whereDate('fecha','<=',$fechafin.' 23:59:59');
        }
        if ($usuario2 != '0') {
            $reservas = $reservas->where('user_id','=', $usuario2);
        }
        $reservas = $reservas->get();

        $counter = User::find($usuario2);

        $pdf= \PDF::loadView('pages.pdf.reservaspdf',compact('fechainicio','fechafin','reservas','usuario2','counter'))->setPaper('a4','landscape');
        return $pdf->download($fechainicio. '-' .$fechafin.'.pdf');
    }

    public function reservasexcel($fechainicio, $fechafin, $usuario2)
    {
        $reservas = Reserva::where('estado', 'LIKE', '%%');
        if ($fechainicio != '0') {
            $reservas = $reservas->whereDate('fecha','>=',$fechainicio.' 00:00:00')
            ->whereDate('fecha','<=',$fechafin.' 23:59:59');
        }
        if ($usuario2 != '0') {
            $reservas = $reservas->where('user_id','=', $usuario2);
        }
        $reservas = $reservas->get();

        $counter = User::find($usuario2);
        return Excel::download(new ReservaExports($fechainicio,$fechafin,$counter,$reservas,$usuario2), 'reservas_excel.xlsx');
    }

}
