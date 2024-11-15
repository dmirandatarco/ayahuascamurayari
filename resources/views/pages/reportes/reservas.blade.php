@extends('layout.master')
@push('plugin-styles')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row inbox-wrapper">
    <div class="col-md-12">
        <div class="card">
        <div style="text-align-last: right !important;margin: 10px 10px 0px 0px;">

        </div>
        <div class="card-body">
            <div class="row">
            <h4 class="mb-3">Buscar Reservas </h4>
            {!!Form::open(array('url'=>'reportes/reservas','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
            <div class="form-group row">
                <div class="col-md-1" style="padding-top: 10px">
                        <span> <strong> Fecha </strong></span>
                    <br>
                </div>
                <div class="col-md-5">
                    <div class="input-group" id="buscarFecha">
                        <input type="date" id="buscarFechaInicio" name="buscarFechaInicio" class="form-control" placeholder="Fecha Inicio" value="{{$fechainicio}}">
                        <label style="padding-top: 10px"><strong> &nbsp;&nbsp; / &nbsp;&nbsp;</strong></label>
                        <input type="date" id="buscarFechaFin" name="buscarFechaFin" class="form-control" placeholder="Fecha Fin"  value="{{$fechafin}}">

                    </div>
                    <br>
                </div>

                <div class="col-md-1" style="padding-top: 10px">
                        <span> <strong> Counter </strong></span>
                    <br>
                </div>
                <div class="col-md-3">
                    <div class="input-group" id="">
                        <select class="form-control" id="buscarUsuario" name="buscarUsuario"  data-live-search="true">
                            <option value="">TODOS</option>
                            @foreach($usuarios as $user)
                                <option value="{{$user->id}}" {{ $usuario == $user->id ? 'selected' : '' }} >{{$user->nombre}} </option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                </div>


                <div class="col-md-2 mb-5">
                    <div class="input-group">
                        <button type="submit"  id="buscar" class="btn btn-primary"><i data-feather="search"></i> Buscar</button>
                    </div>
                </div>
                @if($usuario=="")
                    @php $usuario="0"; @endphp
                @endif
                @if($fechainicio==""||$fechainicio=="%%")
                    @php $fechainicio=0; @endphp
                @endif
                @if($fechafin==""||$fechafin=="%%")
                    @php $fechafin=0; @endphp
                @endif
                @php $sql=[$fechainicio,$fechafin,$usuario]; @endphp
                    <a href="{{route('reportes.reservaspdf',$sql)}}" target="_blank">
                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="PDF" class="btn btn-danger " style='text-align:right;position:absolute;top:0;right:0;margin:20px;'>
                            <i class="mdi mdi-file-pdf-box"></i>
                        </button>
                    </a>
                    <a href="{{route('reportes.reservasexcel',$sql)}}" target="_blank">
                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="PDF" class="btn btn-success " style='text-align:right;position:absolute;top:0;right:0;margin:20px;'>
                            <i class="mdi mdi-file-pdf-box"></i>
                        </button>
                    </a>
            </div>

            {{Form::close()}}
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                </div>
            @endif
            <div class="form-group row">
                <div class="col-md-12 mb-2">
                    <span style="font-size: 20px"><strong style="color:  #6c6c6c;">Total: </strong>{{$total}}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
            </div>
            <div class="table-responsive ">
                <table class="table">
                    <thead>
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
                    </thead>
                    <tbody>
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
    </div>
</div>


@endsection
@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
$('#buscarUsuario').select2();
</script>
@endpush
