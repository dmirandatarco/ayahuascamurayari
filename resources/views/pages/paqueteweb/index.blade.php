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
          <h4 class="mb-3">Listado de Paquetes</h4>
          <div class="mb-5">
            @can('paqueteweb.create')
            <a href="{{ route('paqueteweb.create')}}">
              <button type="button"  data-bs-toggle="tooltip" data-bs-title="Crear" class="btn btn-primary mb-2 mb-md-0 " data-bs-toggle="modal" data-bs-target="#varyingModal">
                <i data-feather="plus-circle"></i><b> &nbsp; Crear Paquete</b>
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
                  <th>NOMBRE</th>
                  <th>DIAS</th>
                  <th>COUNTER</th>
                  <th>IDIOMA</th>
                  @foreach($languages2 as $lanaguage)
                    <th>{{$lanaguage->abreviatura}}</th>
                  @endforeach
                  <th>Editar</th>
                  <th>Ver</th>
                </tr>
              </thead>
              <tbody>
                @foreach($paquetes as $paquete)
                <tr>
                  <td>{{++$i}}</td>
                  <td> {{$paquete->nombre}}</td>
                  <td>{{$paquete->dia}}</td>
                  <td>{{$paquete->user->nombre}}</td>
                  <td><img style="width:25px;" src="{{asset('storage/img/idioma/'.$paquete->language?->icono)}}" alt="{{$paquete->language?->icono}}"></td>
                  </td>
                  @foreach($languages2 as $language)
                    <td>
                      @php
                        $translation = $paquete->traducciones->firstWhere('language_id', $language->id);
                        $inverseTranslation = $paquete->traduccionesinversas->firstWhere('language_id', $language->id);
                        $inverseTranslationespanol = $paquete->traduccionesinversas->firstWhere('language_id', 1);
                        $selectedTranslation = $translation ?? (($inverseTranslation?->language_id == $language->id) ? $inverseTranslation : (($inverseTranslationespanol && $paquete->language_id == $language->id) ? $inverseTranslationespanol : null ));
                      @endphp

                      @if($selectedTranslation)
                        <a  data-bs-toggle="tooltip" data-bs-title="{{$selectedTranslation->nombre}}">
                            <img style="width:25px;" src="{{asset('storage/img/idioma/'.$selectedTranslation->language->icono)}}" alt="{{$language->icono}}">
                        </a>
                      @else
                        <a href="{{ route('paquete.traducir',['lang'=>$language->id,'paquete'=>$paquete]) }}">
                          <button type="button"  data-bs-toggle="tooltip" data-bs-title="Agregar Traduccion" class="btn btn-warning btn-icon edit">
                              <i class="fa-solid fa-plus"></i>
                          </button>
                        </a>
                      @endif
                    </td>
                  @endforeach
                  <td>
                    @can('paquete.ver')
                    <a href="{{ route('paqueteweb.edit',$paquete) }}">
                      <button type="button"  data-bs-toggle="tooltip" data-bs-title="Ver" class="btn btn-primary btn-icon">
                          <i data-feather="edit"></i>
                      </button>
                    </a>
                    </td>
                    <td>
                    @endcan
                    @can('paquete.ver')
                    <a href="{{ route('paquete.ver',$paquete) }}">
                      <button type="button"  data-bs-toggle="tooltip" data-bs-title="Ver" class="btn btn-warning btn-icon">
                          <i data-feather="eye"></i>
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

<div class="modal fade" id="EliminarUsuario"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Cambiar Estado de Reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('paquete.destroy','test')}}" method="POST" autocomplete="off">
          {{method_field('delete')}}
          {{csrf_field()}}
            <p>¿Estás seguro de cambiar el estado?</p>
            <div class="modal-footer">
              <input type="hidden" name="paquete_id" class="paquete_id">
              <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cerrar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Aceptar" class="btn btn-primary">Aceptar</button>
            </div>
        </form>
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

  var idModal = eliminarUsuario.querySelector('.paquete_id')

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
