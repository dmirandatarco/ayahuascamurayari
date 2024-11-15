@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
<div class="row inbox-wrapper">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <h2 class="mb-4">Seguimiento de Tours</h2>
          {!!Form::open(array('route'=>'reserva.seguimiento','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
          <div class="form-group row">
              <div class="col-md-1 mb-3 pt-2">
                      <span> <strong> Fecha: </strong></span>
              </div>
              <div class="col-md-3">
                <input type="date" id="fecha" name="fecha" class="form-control" value="{{$fecha}}">
              </div>
              <div class="col-md-1 mb-3 pt-2">
                <span> <strong> Tour: </strong></span>
              </div>
              <div class="col-md-3">
                <select class="form-select" id="tour" name="tour"  data-live-search="true">
                  <option value="" @selected($valuetour=="")>TODOS</option>
                  @foreach($tours as $tour)
                      <option value="{{$tour->id}}" @selected($valuetour==$tour->id)>{{$tour->nombre}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2 mb-4">
                  <div class="input-group">
                      <button type="submit"  id="buscar" class="btn btn-primary"><i data-feather="search"></i> Buscar</button>
                  </div>
              </div>
          </div>
          {{Form::close()}}
          <div class="table-responsive tableFixHead">
            <table class="table table-responsive table-hover">
              <thead>
                <tr >
                  <th>VER</th>
                  <th>OPERADO</th>
                  <th>FECHA</th>
                  <th>NOMBRE Y APELLIDO</th>
                  <th>NACIONALIDAD</th>
                  <th>CELULAR</th>
                  <th>COUNTER</th>
                  <th>PAX</th>
                  <th>TOUR</th>
                  {{-- <th>TIPO</th> --}}
                  <th>HOTEL</th>
                  <th>SALDO</th>
                  <th>OBSERVACIONES</th>
                  <th>EDITAR</th>
                  <th>PAX</th>
                  <th>PDF</th>
                </tr>
              </thead>
              <tbody>
                @foreach($detalles as $detalle)
                <tr >
                  <td>
                    @can('reserva.ver')
                    <a href="{{ route('reserva.ver',$detalle->reserva) }}">
                      <button type="button"  data-bs-toggle="tooltip" data-bs-title="Ver" class="btn btn-warning btn-icon">
                          <i data-feather="eye"></i>
                      </button>
                    </a>
                    @endcan
                  </td>
                  <td></td>
                  <td class="tablasincortar">{{date("d-m-Y",strtotime($detalle->fecha_viaje))}}</td>
                  <td>{{$detalle->reserva->pasajero->nombre}}</td>
                  <td>{{$detalle->reserva->pasajero->pais->nombre}}</td>
                  <td>{{$detalle->reserva->pasajero->celular}}</td>
                  <td>{{$detalle->reserva->user->nombre}}</td>
                  <td>{{$detalle->cantidad}}</td>
                  <td>{{$detalle->tour->nombre}}</td>
                  {{-- <td>{{$detalle->reserva->privado ? "PRIVADO" : "GRUPAL"}}</td> --}}
                  <td>{{$detalle->hotel->nombre}}</td>
                  <td class="tablasincortar">
                    @foreach($detalle->reserva->totales as $total)
                      @if($loop->last)
                        {{$total->moneda->abreviatura}} {{$total->saldo}}
                      @else
                        {{$total->moneda->abreviatura}} {{$total->saldo}} /
                      @endif
                    @endforeach
                  </td>
                  <td>{{Str::limit($detalle->observacion,80,'...')}}</td>
                  <td>

                    @can('reserva.edit')
                    <a href="{{ route('reserva.edit',$detalle->reserva) }}">
                      <button type="button"  data-bs-toggle="tooltip" data-bs-title="Editar" class="btn btn-primary btn-icon edit" >
                        <i data-feather="edit"></i>
                      </button>
                    </a>
                    @endcan
                  </td>
                  <td>
                    @can('reserva.pasajeros')
                    <a href="{{ route('reserva.pasajeros',$detalle->reserva) }}">
                      <button type="button"  data-bs-toggle="tooltip" data-bs-title="Reserva" class="btn btn-secondary btn-icon">
                        <i data-feather="users"></i>
                      </button>
                    </a>
                    @endcan
                  </td>
                  <td>
                    @can('reserva.ticket')
                    <a href="{{ route('reserva.ticket',$detalle->reserva) }}" target="_blank">
                      <button type="button"  data-bs-toggle="tooltip" data-bs-title="Ticket" class="btn btn-success btn-icon">
                        <i data-feather="file"></i>
                      </button>
                    </a>
                    @endcan
                  </td>
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
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')

<script>

$('#tour').select2();

$(function() {
  'use strict';

  $(function() {
    $('#detalles').DataTable({
      "aLengthMenu": [
        [10, 30, 50, -1],
        [10, 30, 50, "All"]
      ],
      "language": {
        "lengthMenu": "Mostrar  _MENU_  registros por paginas",
        "zeroRecords": "Nada encontrado - disculpa",
        "info": "Mostrando la página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles.",
        "infoFiltered": "(filtrado de _MAX_ registros totales)",
        "search": "Buscar:",
        "paginate":{
          "next": "Siguiente",
          "previous": "Anterior",
        }
      },
      "columnDefs": [
        {
          targets: [7],
          orderable: false
        }
      ]
    });
  });

});
</script>
@endpush
