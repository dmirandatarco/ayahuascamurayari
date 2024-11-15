<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Reserva;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        // Validar la respuesta del proveedor de pago
        $data = $request->all();
        $pago = Pago::find($request->ctransaccioncod);
        $pago->estado = 1;
        $pago->save();
        $reserva = Reserva::find($pago->reserva_id);
        $reserva->confirmado = 1;
        $reserva->save();

        Mail::to($reserva->pasajero?->email)->send(new VoucherMailable($reserva));

        return response()->json([
            'cCodigo' => $reserva->id,
            'cResultado' => 'correcto',
            'cMensaje' => 'registro exitoso',
        ]);
    }
}
