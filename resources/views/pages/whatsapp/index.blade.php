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
          <h4 class="mb-3">Listado de Whatsapps</h4>
          <div class="mb-5">
            @can('whatsapp.create')
            <button type="button"  data-bs-toggle="tooltip" data-bs-title="Crear" class="btn btn-primary mb-2 mb-md-0 " onclick="agregar()">
              <i data-feather="plus-circle"></i><b> &nbsp; Crear Whatsapp</b>
            </button>
            @endcan
          </div>
          @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ $message }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            </div>
          @endif
          <div class="table-responsive">
            <table id="hotels" class="table">
              <thead>
                <tr >
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Cargo</th>
                  <th>Numero</th>
                  <th>Estado</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($whatsapps as $whatsapp)
                <tr>
                  <td>{{++$i}}</td>
                  <td>{{$whatsapp->nombre}}</td>
                  <td>{{$whatsapp->cargo}}</td>
                  <td>{{$whatsapp->numero}}</td>
                  <td>{{$whatsapp->estado ? 'Activo' : 'Inactivo'}}
                  </td>
                  <td>
                    @can('whatsapp.edit')
                    <button type="button"  data-bs-toggle="tooltip" data-bs-title="Editar" class="btn btn-primary btn-icon edit" onclick="editar('{{$whatsapp->id}}','{{$whatsapp->nombre}}','{{$whatsapp->cargo}}','{{$whatsapp->numero}}')" >
                      <i data-feather="edit"></i>
                    </button>
                    @endcan
                    @can('whatsapp.destroy')
                    <button type="button" class="btn btn-danger btn-icon" data-bs-toggle="modal" data-bs-target="#Eliminar" data-id="{{$whatsapp->id}}">
                      <i  data-bs-toggle="tooltip" data-bs-title="Eliminar" data-feather="trash-2"></i>
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

<div class="modal fade" id="Agregar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="spanTexto" ></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('whatsapp.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
        {{csrf_field()}}
          @include('pages.whatsapp.form')
          <input type="hidden" name="tipoform" id="tipoform" value="{{old('tipoform')}}">
          <input type="hidden" name="id_whatsapp" id="id_whatsapp" value="{{old('id_whatsapp')}}">
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="Eliminar" tabindex="-1"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Cambiar Estado </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('whatsapp.destroy','test')}}" method="POST" autocomplete="off">
          {{method_field('delete')}}
          {{csrf_field()}}
            <p>Estas seguro de cambiar el estado?</p>
            <div class="modal-footer">
              <input type="hidden" name="id_whatsapp_2" class="id_whatsapp_2">
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

@if(count($errors)>0)
  @if(old('tipoform')=="crear")
    <script>
        $(function() {
            $('#Agregar').modal('show');
            $('#spanTexto').text("Crear Whatsapp");
        });
    </script>
  @else
    <script>
      $(function() {
          $('#Agregar').modal('show');
          $('#spanTexto').text("Editar Whatsapp");
      });
    </script>
  @endif

@endif

<script>

function agregar(){
  $('#spanTexto').text("Crear Whatsapp");
  $('#tipoform').val("crear");
  $('#id_whatsapp').val(null);
  $('#nombre').val(null);
  $('#cargo').val(null);
  $('#numero').val(null);
  $('#Agregar').modal('show');
}

function editar(id,nombre,cargo,numero){
  $('#Agregar').modal('show');
  $('#spanTexto').text("Editar Whatsapp");
  $('#tipoform').val("editar");
  $('#id_whatsapp').val(id);
  $('#nombre').val(nombre);
  $('#cargo').val(cargo);
  $('#numero').val(numero);
}

var eliminar = document.getElementById('Eliminar');

eliminar.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget
  var id = button.getAttribute('data-id')
  var idModal = eliminar.querySelector('.id_whatsapp_2')
  idModal.value = id;
});

$(function() {
  'use strict';

  $(function() {
    $('#hotels').DataTable({
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
          targets: [5],
          orderable: false
        }
      ]
    });
  });

});
</script>
@endpush
