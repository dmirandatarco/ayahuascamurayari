<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use App\Models\Pasajero;
use App\Models\Reserva;
use App\Models\Total;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\Else_;

class NiubizController extends Controller
{
    public function SessionToken(Request $request)
    {
        $auth = base64_encode(config('services.niubiz.user').':'.config('services.niubiz.password'));
        $accesstoken = Http::withHeaders([
            'Authorization' => 'Basic '.$auth,
        ])
        ->get(config('services.niubiz.url_api').'/api.security/v1/security')
        ->body();

        $mytime= Carbon::now('America/Lima');

        $cliente=Pasajero::updateOrCreate([
            'nombre' => $request->cliente['nombre'],
            'tipo_documento' => $request->cliente['tipo_documento'],
            'num_documento' => $request->cliente['num_documento'],
            'pais_id' => $request->cliente['pais_id'],
        ],[
            'email' => $request->cliente['email'],
            'celular' => $request->cliente['celular'],
            
        ]);

        $reserva = Reserva::create([
            'pasajero_id' => $cliente->id,
            'fecha' => $mytime->toDateTimeString(),
            'user_id' => 1,
            'confirmado' => 0,
            'observacion'=> null,
        ]);

        foreach($request->detalles as $detalle){

            $reserva->detalles()->create([
                'tour_id' => $detalle['id'],
                'hotel_id' => 1,
                'moneda_id' => 2,
                'fecha_viaje' => $mytime->toDateString(),
                'cantidad' => $detalle['pax'],
                'ingreso' => 0,
                'precio' => $detalle['precio'],
                'observacion' => '',
            ]);
        }

        $reserva->totales()->create([
            'moneda_id' => 2,
            'acuenta' => 0,
            'saldo' => $request->total,
            'total' => $request->total,
        ]);

        $pago20 = $request->total*0.2;

        $sessionKey = Http::withHeaders([
            'Authorization' => $accesstoken,
            'Content-Type' => 'application/json'
        ])
        ->post(config('services.niubiz.url_api').'/api.ecommerce/v2/ecommerce/token/session/'.config('services.niubiz.merchant_id'),[
            "channel"=> "web",
            "amount"=> $pago20,
            "antifraud"=> [
                "clientIp"=> request()->ip(),
                "merchantDefineData"=> [
                    "MDD4"=> $cliente->email,
                    "MDD21"=> 0,
                    "MDD32"=> $cliente->id,
                    "MDD75"=> "Invitado",
                    "MDD77"=> 1
                ]
            ]
        ])->json();

        $sessionKey = $sessionKey['sessionKey'];

        $data = [
            'sessionKey' => $sessionKey,
            'logo' => asset('img/logo.png'),
            'reserva_id' => $reserva->id,
            'merchant_id' => config('services.niubiz.merchant_id'),
            'link_js' => config('services.niubiz.url_js'),
            'pago' => $pago20,
            'route' => env('URL_WEB').'/api/niubiz-pago'.'?pago='.$pago20.'&reserva='.$reserva->id
        ];

        return response()->json($data);
    }

    public function pagoNiubiz(Request $request)
    {
        $auth = base64_encode(config('services.niubiz.user').':'.config('services.niubiz.password'));
        $accesstoken = Http::withHeaders([
            'Authorization' => 'Basic '.$auth,
        ])
        ->get(config('services.niubiz.url_api').'/api.security/v1/security')
        ->body();

        $response = Http::withHeaders([
            'Authorization' => $accesstoken,
            'Content-Type' => 'application/json'
        ])
        ->post(config('services.niubiz.url_api').'/api.authorization/v3/authorization/ecommerce/'.config('services.niubiz.merchant_id'),[
            "channel"=> "web",
            "captureType"=> "manual",
            "countable"=> true,
            "order" => [
                "tokenId"=> $request->transactionToken,
                "purchaseNumber"=> $request->reserva,
                "amount"=> $request->pago,
                "currency"=> "USD"
            ]
        ])->json();

        if(isset($response['dataMap']) && $response['dataMap']['ACTION_CODE'] === '000'){
            $reserva = Reserva::find($request->reserva);
            $fecha = now()->createFromFormat('ymdHis',$response['dataMap']['TRANSACTION_DATE'])->format('Y-m-d H:i:s');

            $pago = Pago::create([
                'user_id' => 1,
                'moneda_id' => 2,
                'medio_id' => 1,
                'reserva_id' => $reserva->id,
                'fecha' => $fecha,
                'monto' => $response['order']['amount'],
                'tarjeta' => $response['dataMap']['CARD'].' ('.$response['dataMap']['BRAND'].')',
                'operacion' => $response['order']['transactionId'],
                'mensaje' => $response['dataMap']['ACTION_DESCRIPTION'],
                'confirmado' => 1
            ]);

            $total = Total::where('moneda_id',2)->where('reserva_id',$reserva->id)->first();
            $total->acuenta = $total->acuenta + $response['order']['amount'];
            $total->saldo = $total->saldo - $response['order']['amount'];
            $total->save();

            return Redirect::away('http://192.168.1.14:5174/valid-checkout?id='.$pago->id);
        }else{
            $reserva = Reserva::find($request->reserva);
            $fecha = now()->createFromFormat('ymdHis',$response['data']['TRANSACTION_DATE'])->format('Y-m-d H:i:s');

            $pago = Pago::create([
                'user_id' => 1,
                'moneda_id' => 2,
                'medio_id' => 1,
                'reserva_id' => $reserva->id,
                'fecha' => $fecha,
                'monto' => 0.00,
                'tarjeta' => $response['data']['CARD'].' ('.$response['data']['BRAND'].')',
                'operacion' => $response['data']['TRANSACTION_ID'],
                'mensaje' => $response['data']['ACTION_DESCRIPTION'],
                'confirmado' => 0
            ]);

            return Redirect::away('http://192.168.1.14:5174/invalid-checkout?id='.$pago->id);
        }
    }

    public function confirmarPago(Request $request)
    {
        $pago = Pago::find($request->id);
        return response()->json($pago);
    }
}
