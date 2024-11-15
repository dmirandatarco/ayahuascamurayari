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
            <h4 class="mb-3">Listado de Tours</h4>
            <div class="mb-5">
                @can('tour.create')
                <a href="{{ route('tour.create')}}">
                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Crear" class="btn btn-primary mb-2 mb-md-0 " data-bs-toggle="modal" data-bs-target="#varyingModal">
                    <i data-feather="plus-circle"></i><b> &nbsp; Crear Tour</b>
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
                <table id="tours" class="table">
                <thead>
                    <tr >
                    <th>Nº</th>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Web</th>
                    <th>Destacado</th>
                    <th>Idioma</th>
                    @foreach($languages2 as $lanaguage)
                        <th>{{$lanaguage->abreviatura}}</th>
                    @endforeach
                    <th>Estado</th>
                    <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tours as $tour)
                    <tr>
                    <td>{{++$i}}</td>
                    <td> {{$tour->nombre}}</td>
                    <td>{{$tour->categoria->nombre}}</td>
                    <td>{{$tour->web ? 'Si' : 'No'}} </td>
                    <td>{{$tour->destacado ? 'Si' : 'No'}} </td>
                    <td><img style="width:25px;" src="{{$tour->language?->icono}}" alt="{{$tour->language?->icono}}"></td>
                    @foreach($languages2 as $language)
                        <td>
                        @php
                            $translation = $tour->traducciones->firstWhere('language_id', $language->id);
                            $inverseTranslation = $tour->traduccionesinversas->firstWhere('language_id', $language->id);
                            $inverseTranslationespanol = $tour->traduccionesinversas->firstWhere('language_id', 1);
                            $selectedTranslation = $translation ?? (($inverseTranslation?->language_id == $language->id) ? $inverseTranslation : (($inverseTranslationespanol && $tour->language_id == $language->id) ? $inverseTranslationespanol : null ));
                        @endphp

                        @if($selectedTranslation)
                            <a  data-bs-toggle="tooltip" data-bs-title="{{$selectedTranslation->nombre}}" href="{{ route('tour.edit',$selectedTranslation) }}">
                                <img style="width:25px;" src="{{$selectedTranslation->language->icono}}" alt="{{$language->icono}}">
                            </a>
                        @else
                            <a href="{{ route('tour.traducir',['lang'=>$language->id,'tour'=>$tour]) }}">
                            <button type="button"  data-bs-toggle="tooltip" data-bs-title="Agregar Traduccion" class="btn btn-warning btn-icon edit">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            </a>
                        @endif
                        </td>
                    @endforeach
                    <td>{{$tour->estado ? 'Activo' : 'Inactivo'}} </td>
                    <td>
                        @can('tour.show')
                        <a href="{{ route('tour.show',$tour) }}">
                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Ver" class="btn btn-warning btn-icon">
                            <i data-feather="eye"></i>
                        </button>
                        </a>
                        @endcan
                        @can('tour.edit')
                        <a href="{{ route('tour.edit',$tour) }}">
                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Editar" class="btn btn-primary btn-icon edit" >
                            <i data-feather="edit"></i>
                        </button>
                        </a>
                        @endcan
                        @can('tour.destroy')
                        <button type="button" class="btn btn-danger btn-icon" data-bs-toggle="modal" data-bs-target="#EliminarUsuario" data-id="{{$tour->id}}">
                        <i  data-bs-toggle="tooltip" data-bs-title="Eliminar" data-feather="lock"></i>
                        </button>
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
            <h5 class="modal-title" >Cambiar Estado de Tour</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
        </div>
        <div class="modal-body">
            <form action="{{route('tour.destroy','test')}}" method="POST" autocomplete="off">
            {{method_field('delete')}}
            {{csrf_field()}}
                <p>¿Estás seguro de cambiar el estado?</p>
                <div class="modal-footer">
                <input type="hidden" name="id_tour_2" class="id_tour_2">
                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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

  var idModal = eliminarUsuario.querySelector('.id_tour_2')

  idModal.value = id;
})

$(function() {
  'use strict';

  $(function() {
    $('#tours').DataTable({
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
          targets: [6],
          orderable: false
        }
      ]
    });
  });

});
</script>
@endpush
