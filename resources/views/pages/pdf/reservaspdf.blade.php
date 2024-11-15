<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Reservas</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.6rem;
            font-weight: normal;
            line-height: .05;
            color: #151b1e;
            writing-mode: tb-rl;
            size:landscape;
            width:100%;
            height:100%;
            TEXT-TRANSFORM:UPPERCASE;

        }

        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 0.3rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.05rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 1px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 1px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
            line-height: 1.6;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
            line-height: 1.6;
        }
        tbody {
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
            line-height: 1.6;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }
        .resumen{
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

<div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
    <div class="card">
        <div class="row">
            <h3 style="text-align:center; font-size:15px"> Reporte de Reservas</h3>
            <img class="derecha" style="padding-top:0; margin-top:0; margin-right:1rem;" src="../public/img/logo.png"  width="205px"  alt="admin@bootstrapmaster.com">
            <p><b>Desde:</b>   {{date("d-m-Y ",strtotime($fechainicio))}}</p><br>
            <p><b>Hasta:</b>  {{date("d-m-Y ",strtotime($fechafin))}}</p><br>
            <p><b>Counter:</b>  {{$counter?->nombre}}</p><br>
            <div class="card-body" style="margin-top:1rem;">
                    <div style="overflow-x:auto;">
                            <div class="table-responsive" >
                                <table id="egresos" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr style="background-color: #4CAF50; color:#ffffff; font-size:12px ">
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
                                    </thead>
                                    <tbody>
                                        @foreach ($reservas as $reserva)
                                            <tr>
                                                <td>@can('reserva.ver')
                                                    <a href="{{ route('reserva.ver',$reserva) }}">
                                                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Ver" class="btn btn-warning btn-icon">
                                                            <i data-feather="eye"></i>
                                                        </button>
                                                    </a>
                                                    @endcan
                                                </td>
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
        </div>
    </div>
</div>
</body>

</html>
