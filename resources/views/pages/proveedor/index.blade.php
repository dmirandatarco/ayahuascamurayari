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
          <h4 class="mb-3">Listado de Proveedores</h4>
          <div class="mb-5">
            @can('proveedor.create')
            <button type="button"  data-bs-toggle="tooltip" data-bs-title="Crear" class="btn btn-primary mb-2 mb-md-0 " onclick="agregar()">
              <i data-feather="plus-circle"></i><b> &nbsp; Crear proveedor</b>
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
            <table id="proveedors" class="table">
              <thead>
                <tr >
                  <th>Numero</th>
                  <th>Nombre</th>
                  <th>Celular</th>
                  <th>Direccion</th>
                  <th>Precio</th>
                  <th>Servicios</th>
                  <th>Estado</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($proveedores as $proveedor)
                <tr>
                  <td>{{++$i}}</td>
                  <td>{{$proveedor->nombre}}</td>
                  <td>{{$proveedor->celular}}</td>
                  <td>{{$proveedor->direccion}}</td>
                  <td>{{$proveedor->precio}}</td>
                  <td>{{$proveedor->servicio->nombre}}</td>
                  <td>
                    @if($proveedor->estado==1)
                      Activo
                    @else
                      Inactivo
                    @endif
                  </td>
                  <td>
                    @can('proveedor.edit')
                    <button type="button"  data-bs-toggle="tooltip" data-bs-title="Editar" class="btn btn-primary btn-icon edit" onclick="editar('{{$proveedor->id}}','{{$proveedor->nombre}}','{{$proveedor->celular}}','{{$proveedor->direccion}}','{{$proveedor->precio}}','{{$proveedor->servicio_id}}')" >
                      <i data-feather="edit"></i>
                    </button>
                    @endcan
                    @can('proveedor.destroy')
                    <button type="button"  data-bs-toggle="tooltip" data-bs-title="Eliminar" class="btn btn-danger btn-icon" data-bs-toggle="modal" data-bs-target="#Eliminar" data-id="{{$proveedor->id}}">
                      <i data-feather="trash-2"></i>
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
        <form action="{{route('proveedor.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
        {{csrf_field()}}
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control nombre" id="nombre" name="nombre" value="{{old('nombre')}}">
            @error('nombre')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="celular" class="form-label">Celular:</label>
            <input type="text" class="form-control celular" id="celular" name="celular" value="{{old('celular')}}">
            @error('celular')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="direccion" class="form-label">Dirección:</label>
            <input type="text" class="form-control direccion" id="direccion" name="direccion" value="{{old('direccion')}}">
            @error('direccion')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="precio" class="form-label">Precio:</label>
            <input type="number" class="form-control precio" id="precio" name="precio" value="{{old('precio')}}" step="0.01">
            @error('precio')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="servicio_id" class="form-label">Servicio:</label>
            <div >
              <select class="js-example-basic-single form-control" name="servicio_id" id="servicio_id" data-live-search="true">
                <option value="" >SELECCIONE</option>
                @foreach($servicios as $servicio)
                    <option value="{{$servicio->id}}" @selected(old('servicio_id')==$servicio->id)>{{$servicio->nombre}}</option>
                @endforeach
              </select>
              @error('servicio_id')
                <span class="error-message" style="color:red">{{ $message }}</span>
              @enderror
            </div>
          </div>
          <input type="hidden" name="tipoform" id="tipoform" value="{{old('tipoform')}}">
          <input type="hidden" name="id_proveedor" id="id_proveedor" value="{{old('id_proveedor')}}">
          <div class="modal-footer">
            <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cerrar" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Guardar" class="btn btn-primary">Guardar</button>
          </div>
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
        <form action="{{route('proveedor.destroy','test')}}" method="POST" autocomplete="off">
          {{method_field('delete')}}
          {{csrf_field()}}
            <p>Estas seguro de cambiar el estado?</p>
            <div class="modal-footer">
              <input type="hidden" name="id_proveedor_2" class="id_proveedor_2">
              <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cerrar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')

@if(count($errors)>0)
  @if(old('tipoform')=="crear")
    <script>
        $(function() {
            $('#Agregar').modal('show');
            $('#spanTexto').text("Crear proveedor");
        });
    </script>
  @else
    <script>
      $(function() {
          $('#Agregar').modal('show');
          $('#spanTexto').text("Editar proveedor");
      });
    </script>
  @endif

@endif

<script>

$(document).ready(function() {
    $("#servicio_id").select2({
        dropdownParent: $("#Agregar"),
        width: '100%'
    });
})

function agregar(){
  $('#spanTexto').text("Crear proveedor");
  $('#tipoform').val("crear");
  $('#id_proveedor').val(null);
  $('#nombre').val(null);
  $('#celular').val(null);
  $('#direccion').val(null);
  $('#precio').val(null);
  $('#servicio_id').select2('destroy');
  $('#servicio_id').val(null).select2({
        dropdownParent: $("#Agregar"),
        width: '100%'
    });
  $('#Agregar').modal('show');
}

function editar(id,nombre,celular,direccion,precio,servicio){
  $('#Agregar').modal('show');
  $('#spanTexto').text("Editar proveedor");
  $('#tipoform').val("editar");
  $('#id_proveedor').val(id);
  $('#nombre').val(nombre);
  $('#celular').val(celular);
  $('#direccion').val(direccion);
  $('#servicio_id').select2('destroy');
  $('#servicio_id').val(servicio).select2({
        dropdownParent: $("#Agregar"),
        width: '100%'
    });
  $('#precio').val(precio);
}

var eliminar = document.getElementById('Eliminar');

eliminar.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget
  var id = button.getAttribute('data-id')
  var idModal = eliminar.querySelector('.id_proveedor_2')
  idModal.value = id;
});

$(function() {
  'use strict';

  $(function() {
    $('#proveedors').DataTable({
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
