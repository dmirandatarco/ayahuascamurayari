@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush
@section('content')
<div class="row inbox-wrapper">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <h4 class="mb-3">Listado de Reservas</h4>
          <div class="mb-5">
            @can('reserva.create')
            <a href="{{ route('reserva.create')}}">
              <button type="button" class="btn btn-primary mb-2 mb-md-0 " data-bs-toggle="modal" data-bs-target="#varyingModal">
                <i  data-bs-toggle="tooltip" data-bs-title="Crear" data-feather="plus-circle"></i><b> &nbsp; Crear Reserva</b>
              </button>
            </a>
            @endcan
          </div>
          @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ $message }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            </div>
          @endif
          <div class="table-responsive">
            <table id="reservas" class="table">
              <thead>
                <tr >
                  <th>Nº</th>
                  <th>PASAJERO</th>
                  <th>COUNTER</th>
                  {{-- <th>TIPO</th> --}}
                  <th>A CUENTA</th>
                  <th>SALDO</th>
                  <th>TOTAL</th>
                  <th>ESTADO</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($reservas as $reserva)
                <tr>
                  <td>{{++$i}}</td>
                  <td> {{$reserva->pasajero->nombre}}</td>
                  <td>{{$reserva->user->nombre}}</td>
                  {{-- <td>{{$reserva->privado ? "PRIVADO" : "GRUPAL"}}</td> --}}
                  <td>
                    @foreach($reserva->totales as $total)
                      @if($loop->last)
                        {{$total->moneda->abreviatura}} {{$total->acuenta}}
                      @else
                        {{$total->moneda->abreviatura}} {{$total->acuenta}} /
                      @endif
                    @endforeach
                  </td>
                  <td>
                    @foreach($reserva->totales as $total)
                      @if($loop->last)
                        {{$total->moneda->abreviatura}} {{$total->saldo}}
                      @else
                        {{$total->moneda->abreviatura}} {{$total->saldo}} /
                      @endif
                    @endforeach
                  </td>
                  <td>
                    @foreach($reserva->totales as $total)
                      @if($loop->last)
                        {{$total->moneda->abreviatura}} {{$total->total}}
                      @else
                        {{$total->moneda->abreviatura}} {{$total->total}} /
                      @endif
                    @endforeach
                  </td>
                  <td>
                    @if($reserva->estado==1)
                      Registrado
                    @elseif($reserva->estado==2)
                      Pagado
                    @else
                      Anulado
                    @endif
                  </td>
                  <td>
                    @can('reserva.ver')
                    <a href="{{ route('reserva.ver',$reserva) }}">
                      <button type="button"  data-bs-toggle="tooltip" data-bs-title="Ver" class="btn btn-warning btn-icon">
                          <i data-feather="eye"></i>
                      </button>
                    </a>
                    @endcan
                    @can('reserva.edit')
                    <a href="{{ route('reserva.edit',$reserva) }}">
                      <button type="button"  data-bs-toggle="tooltip" data-bs-title="Editar" class="btn btn-primary btn-icon edit" >
                        <i data-feather="edit"></i>
                      </button>
                    </a>
                    @endcan
                    @can('reserva.destroy')
                      @if($reserva->estado==1 || $reserva->estado==0)
                        <button type="button" class="btn btn-danger btn-icon" data-bs-toggle="modal" data-bs-target="#EliminarUsuario" data-id="{{$reserva->id}}">
                          <i  data-bs-toggle="tooltip" data-bs-title="Eliminar" data-feather="lock"></i>
                        </button>
                      @endif
                    @endcan
                    @can('reserva.ticket')
                    <a href="{{ route('reserva.ticket',$reserva) }}" target="_blank">
                      <button type="button"  data-bs-toggle="tooltip" data-bs-title="Pdf" class="btn btn-success btn-icon">
                        <i data-feather="file"></i>
                      </button>
                    </a>
                    @endcan
                    @if($reserva->pasajero?->email != '')
                    <a href="{{ route('reserva.notificar',$reserva) }}">
                      <button type="button"  class="btn btn-success btn-icon" data-bs-toggle="tooltip" data-bs-title="notificar" >
                        <i data-feather="link" ></i>
                      </button>
                    </a>
                    @endif
                      {{-- <button type="button"  class="btn btn-success btn-icon" data-bs-toggle="modal" data-bs-target="#AgregarPago">
                        <i data-feather="link" ></i>
                      </button> --}}
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

<div class="modal fade" id="AgregarPago"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Monto de Pago</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('reserva.destroy','test')}}" method="POST" autocomplete="off">
          {{csrf_field()}}
            <div class="mb-3">
              <label for="moneda_id" class="form-label">Moneda:</label>
              <div >
                <select class="js-example-basic-single form-control moneda_id" name="moneda_id" id="moneda_id" data-live-search="true">
                  <option value="" >SELECCIONE</option>
                    <option value="1" @selected(old('moneda_id')==1)>S/ Soles</option>
                    <option value="2" @selected(old('moneda_id')==2)>$ Dolares</option>
                </select>
                @error('moneda_id')
                  <span class="error-message" style="color:red">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="mb-3">
              <label for="monto" class="form-label">Monto:</label>
              <input type="number" class="form-control" id="monto" name="monto" value="{{old('monto')}}">
              @error('monto')
                <span class="error-message" style="color:red">{{ $message }}</span>
              @enderror
            </div>
            <div class="modal-footer">
              <input type="hidden" name="id_reserva_2" class="id_reserva_2">
              <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Aceptar" class="btn btn-primary">Aceptar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="EliminarUsuario"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Cambiar Estado de Reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('reserva.destroy','test')}}" method="POST" autocomplete="off">
          {{method_field('delete')}}
          {{csrf_field()}}
            <p>¿Estás seguro de cambiar el estado?</p>
            <div class="modal-footer">
              <input type="hidden" name="id_reserva_2" class="id_reserva_2">
              <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Aceptar" class="btn btn-primary">Aceptar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>



@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')

<script>

var eliminarUsuario = document.getElementById('EliminarUsuario');

eliminarUsuario.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget

  var id = button.getAttribute('data-id')

  var idModal = eliminarUsuario.querySelector('.id_reserva_2')

  idModal.value = id;
})

$(function() {
  'use strict';

  $(function() {
    $('#reservas').DataTable({
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
