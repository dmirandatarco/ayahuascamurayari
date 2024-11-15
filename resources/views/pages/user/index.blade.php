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
          <h4 class="mb-3">Listado de Usuarios</h4>
          <div class="mb-5">
            @can('user.create')
            <a href="{{ route('user.create')}}">
              <button type="button" class="btn btn-primary mb-2 mb-md-0 " data-bs-toggle="modal" data-bs-target="#varyingModal">
                <i  data-bs-toggle="tooltip" data-bs-title="Crear" data-feather="user-plus"></i><b> &nbsp; Crear Usuario</b>
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
            <table id="usuarios" class="table">
              <thead>
                <tr >
                  <th>Numero</th>
                  <th>Nombre</th>
                  <th>Usuario</th>
                  <th>Rol</th>
                  <th>Tipo Documento</th>
                  <th>Numero</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                <tr>
                  <td>{{++$i}}</td>
                  <td> {{$user->nombre}} {{$user->apellido}}</td>
                  <td>{{$user->usuario}}</td>
                  <td>
                    @foreach($user->roles as $role)
                      {{$role->name}}
                    @endforeach</td>
                  <td>{{$user->tipo_documento}}</td>
                  <td>{{$user->num_documento}}</td>
                  <td>
                    @if($user->estado==1)
                      Activo
                    @else
                      Inactivo
                    @endif
                  </td>
                  <td>
                    @can('user.show')
                    <a href="{{ route('user.show',$user->id) }}">
                      <button type="button" class="btn btn-warning btn-icon"  data-bs-toggle="tooltip" data-bs-title="Ver">                          <i data-feather="eye"></i>
                      </button>
                    </a>
                    @endcan
                    @can('user.edit')
                    <a href="{{ route('user.edit',$user->id) }}" >
                      <button type="button" class="btn btn-primary btn-icon edit" data-bs-toggle="tooltip" data-bs-title="Editar" >
                        <i data-feather="edit"></i>
                      </button>
                    </a>
                    @endcan
                    @can('user.destroy')
                    <button type="button" class="btn btn-danger btn-icon" data-bs-toggle="modal" data-bs-target="#EliminarUsuario" data-id="{{$user->id}}">
                      <i data-bs-toggle="tooltip" data-bs-title="Eliminar" data-feather="lock"></i>
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
        <h5 class="modal-title" >Cambiar Estado de Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('user.destroy','test')}}" method="POST" autocomplete="off">
          {{method_field('delete')}}
          {{csrf_field()}}
            <p>¿Estás seguro de cambiar el estado?</p>
            <div class="modal-footer">
              <input type="hidden" name="id_usuario_2" class="id_usuario_2">
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
@if(!empty(Session::get('error_code')) && Session::get('error_code') == 5)
<script>
    $(function() {
        $('#EditarUsuario').modal('show');
    });
</script>
@else
  @if(count($errors)>0)
  <script>
      $(function() {
          $('#AgregarUsuario').modal('show');
      });
  </script>
  @endif
@endif

<script>

var eliminarUsuario = document.getElementById('EliminarUsuario');

eliminarUsuario.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget

  var id = button.getAttribute('data-id')

  var idModal = eliminarUsuario.querySelector('.id_usuario_2')

  idModal.value = id;
})

$(function() {
  'use strict';

  $(function() {
    $('#usuarios').DataTable({
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
