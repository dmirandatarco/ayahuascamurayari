<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Operacion Tour</title>
    <style>



body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.8rem;
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
            padding: 0.3rem;
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
            line-height: 1.5;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
            line-height: 1.5;
        }
        tbody {
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
            line-height: 1.5;
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
        .text-center{
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="card">
        <div class="row">
            <h1 style="TEXT-ALIGN: CENTER; color:#4CAF50; padding-bottom: 20px;"> Tour Operador Nº {{$operar->id}}: {{$operar->tour->nombre}}</h1>
            <div class="card-body">
                <div class="table-responsive" >
                    <table  class="table table-sm">
                        <tbody>
                            <tr>
                                <td class="id_pasajero" style="border-top:0px; font-size:12px; color:#2A3787;"></td>
                                <td class="id_pasajero"style="border-top:0px; font-size:12px; color:#2A3787;"></td>
                                <td rowspan="2" style="border-top:0px;"></td>
                            </tr>
                            <tr>
                                <td class="id_pasajero" style="border-top:0px; font-size:12px; color:#2A3787;"><b>Fecha: </b>{{date("d/m/Y", strtotime($operar->fecha))}}</td>
                                <td class="id_pasajero"style="border-top:0px; font-size:12px; color:#2A3787;"><b  >Total Pasajeros: </b>{{$operar->cantidad}}</td>
                                <td rowspan="2" style="border-top:0px;"><img class="derecha" style="padding-top:0; margin-top:-2rem; margin-right:1rem"  src="{{ asset('img/logo.png')}}" width="205px"  alt="admin@bootstrapmaster.com"></td>
                            </tr>
                            <tr>
                                @foreach($operar->proveedors as $proveedor)
                                    <td class="nombre" style="border-top:0px; font-size:12px;color:#2A3787;"><b >{{$proveedor->servicio->nombre}}: </b>{{$proveedor->nombre}}</td>
                                @endforeach
                            </tr>
                        
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive" >
                            
                    <table id="detalles" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr style="background-color:#4CAF50; color:#ffffff; font-size: 12px;">
                                
                                <th><label class="text-center"> PAX</label></th>
                                <th><label class="text-center"> PASAJERO</label></th>
                                <th><label class="text-center"> CONTRATO</label></th>
                                <th><label class="text-center"> HOTEL</label></th>
                                <th><label class="text-center"> INGRESOS</label></th>
                                <th><label class="text-center"> HORA DE RECOJO</label></th>
                                <th><label class="text-center"> SALDO</label></th>
                                <th><label class="text-center"> OBSERVACIONES</label></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($operar->detallesoperar as $detalle)
                            <tr>
                                <td>{{$detalle->detalle->cantidad}}</td>
                                <td>{{$detalle->detalle->reserva->pasajero->nombre}} {{$detalle->detalle->reserva->pasajero->celular}}</td>
                                <td>{{$detalle->detalle->reserva->user->nombre}} </td>
                                <td>{{$detalle->detalle->hotel->nombre}}</td>
                                <td>{{$detalle->detalle->ingreso}}</td>
                                <td>{{$detalle->horarecojo}}</td>
                                <td>
                                    @foreach($detalle->detalle->reserva->totales as $total)
                                        @if($loop->last)
                                            {{$total->moneda->abreviatura}} {{$total->saldo}}
                                        @else
                                            {{$total->moneda->abreviatura}} {{$total->saldo}} /
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$detalle->detalle->observacion}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                        

                </div>
            </div>
            <span style="color:red; line-height: 20px; font-size: 12px"><b>Enviar: </b>{{$operar->monto_dar}}</span><br>
            <span style="line-height: 20px; font-size: 12px"><b>Observaciones: </b>{{$operar->observacion}}</span>
        </div>
    </div>
</div>
</body>

</html>