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
          <h4 class="mb-3">Listado de Roles</h4>
          <div class="mb-5">
            @can('role.create')
            <a href="{{ route('roles.create')}}">
              <button type="button" data-bs-toggle="tooltip" data-bs-title="Crear" class="btn btn-primary mb-2 mb-md-0 ">
                <i data-feather="plus-circle"></i><b> &nbsp; Crear Rol</b>
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
            <table id="roles" class="table">
              <thead>
                <tr >
                  <th>Numero</th>
                  <th>Nombre</th>
                  <th ></th>
                  <th ></th>
                </tr>
              </thead>
              <tbody>
                @foreach($roles as $role)
                <tr>
                  <td>{{++$i}}</td>
                  <td>{{$role->name}}</td>
                  <td>
                    @can('role.edit')
                      <a href="{{ route('roles.edit',$role) }}">
                      <button type="submit" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-title="Ver"><i data-feather="edit"></i></button> </a>
                    @endcan
                  </td>
                  <td>
                    @can('role.destroy')
                    <form action="{{ route('roles.destroy',$role) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-icon" data-bs-toggle="tooltip" data-bs-title="Desactivar"><i data-feather="lock"></i></button>
                    </form>
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
@endpush

@push('custom-scripts')

<script>


$(function() {
  'use strict';

  $(function() {
    $('#roles').DataTable({
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
          targets: [2,3],
          orderable: false
        }
      ]
    });
  });

});
</script>
@endpush



