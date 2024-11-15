<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REPORTE DE RESERVAS</title>
    <style>
    </style>
</head>
<body>
<div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
    <div class="card">
        <div class="row">
            <div class="table-responsive" >
            <table  class="table table-bordered table-striped table-sm">
                <thead >
                    <tr>
                        <td rowspan="2">

                        </td>
                        <td colspan="10">
                            <h3 class="text-uppercase m0">
                                DAY EXPEDITIONS CUSCO
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <p class="m0">
                                Dirección: <strong>Calle Plateros Nº 328 - Cusco</strong>
                            </p>
                        </td>
                    </tr>
                    <tr >
                        <th colspan="11">REPORTE DE RESERVAS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    </tr>
                    <tr>
                        <td>DESDE: </td>
                        <td STYLE="text-align:center">{{date("d-m-Y ",strtotime($fechainicio))}}</td>
                        <td>HASTA: </td>
                        <td STYLE="text-align:center">{{date("d-m-Y ",strtotime($fechafin))}}</td>
                    </tr>
                    <tr>
                        <td>COUNTER: </td>
                        <td STYLE="text-align:center">{{$counter?->nombre}}</td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <th>Nº Reserva</th>
                        <th>Fecha</th>
                        <th>Pasajero</th>
                        <th>Counter</th>
                        <th>Acuenta S/</th>
                        <th>Saldo S/</th>
                        <th>Total S/</th>
                        <th>Acuenta $</th>
                        <th>Saldo $</th>
                        <th>Total $</th>
                        <th>Estado</th>
                    </tr>
                    @foreach ($reservas as $reserva)
                        <tr>
                            <td>{{$reserva->id}}</td>
                            <td>{{ date("d-m-Y H:i:s",strtotime($reserva->fecha)) }}</td>
                            <td>{{ $reserva->pasajero->nombre }}</td>
                            <td>{{ $reserva->user->nombre }}</td>
                            @foreach($reserva->totales as $total)
                                @if(count($reserva->totales)==1)
                                    @if($total->moneda_id == 1)
                                        <td>{{ $total->acuenta }}</td>
                                        <td>{{ $total->saldo }}</td>
                                        <td>{{ $total->total }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @else
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $total->acuenta }}</td>
                                        <td>{{ $total->saldo }}</td>
                                        <td>{{ $total->total }}</td>
                                    @endif
                                @else
                                    <td>{{ $total->acuenta }}</td>
                                    <td>{{ $total->saldo }}</td>
                                    <td>{{ $total->total }}</td>
                                @endif
                            @endforeach
                            <td>{{ $reserva->estado == '1' ? 'Registrado' : 'Anulado'}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
</body>

</html>