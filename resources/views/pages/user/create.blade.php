@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
<form action="{{route('user.store')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
{{csrf_field()}}
<div class="row inbox-wrapper">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
            <div class="mb-3">              
              <img src="{{asset('storage/img/usuario/default.png')}}" alt="" class="wd-250 ht-250 rounded-circle">
              <input type="file" name="imagen">
            </div>
            <div class="text-center">
              <p class="tx-16 fw-bolder">Nombre de Usuario</p>
              <p class="tx-12 text-muted">Cargo</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <h4 class="mb-3">Crear Nuevo Usuario</h4>   
            <div class="row">
              <div class="mb-3 col-md-6" >
                <label class="form-label" for="tipo_documento">Tipo de Documento</label>
                <select class="js-example-basic-single form-select" id="tipo_documento" name="tipo_documento" data-width="100%">
                  <option value="DNI" @selected(old('tipo_documento')=="DNI")>DNI</option>
                  <option value="RUC" @selected(old('tipo_documento')=="RUC")>RUC</option>                  
                </select>    
                @error('tipo_documento')
                  <span class="error-message" style="color:red">{{ $message }}</span>
                @enderror        
              </div>
              <div class="mb-3 col-md-6">
                <label for="num_documento" class="form-label">Numero de Documento:</label>
                <input type="text" name="num_documento"  id="num_documento" class="form-control" value="{{old('num_documento')}}" >
                @error('num_documento')
                  <span class="error-message" style="color:red">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="mb-3 col-md-4">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" name="nombre"  id="nombre" class="form-control" value="{{old('nombre')}}" >
                @error('nombre')
                  <span class="error-message" style="color:red">{{ $message }}</span>
                @enderror
              </div>
              <div class="mb-3 col-md-4">
                <label for="apellido" class="form-label">Apellidos:</label>
                <input type="text" name="apellido"  id="apellido" class="form-control" value="{{old('apellido')}}" >
                @error('apellido')
                  <span class="error-message" style="color:red">{{ $message }}</span>
                @enderror
              </div>
              <div class="mb-3 col-md-4">
                <label for="celular" class="form-label">Celular</label>
                <input type="text" name="celular" id="celular" class="form-control" value="{{old('celular')}}" >
                @error('celular')
                  <span class="error-message" style="color:red">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario"  id="usuario" class="form-control" value="{{old('usuario')}}" >
                @error('usuario')
                  <span class="error-message" style="color:red">{{ $message }}</span>
                @enderror
              </div>
              <div class="mb-3 col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control"  >
                @error('password')
                  <span class="error-message" style="color:red">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="mb-3 col-md-4" >
                <label class="form-label">Rol</label>
                <select class="js-example-basic-single form-select" id="idrol" name="idrol" data-width="100%">
                  @foreach($roles as $role)
                      <option value="{{$role->id}}" @selected(old('idrol')==$role->id)>{{$role->name}}</option>
                  @endforeach                  
                </select>    
                @error('idrol')
                  <span class="error-message" style="color:red">{{ $message }}</span>
                @enderror        
              </div>
              <div class="mb-3 col-md-5">
                <label for="email" class="form-label">E-mail:</label>
                <input type="text" name="email" class="form-control" for="email" value="{{old('email')}}">
                @error('email')
                  <span class="error-message" style="color:red">{{ $message }}</span>
                @enderror
              </div>
              <div class="mb-3 col-md-3">
                <label for="cumpleaños" class="form-label">Cumpleaños:</label>
                <input type="date" name="cumpleaños" class="form-control" for="cumpleaños" value="{{old('cumpleaños')}}">
                @error('cumpleaños')
                  <span class="error-message" style="color:red">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <button type="submit" class="btn btn-primary me-2">Crear Usuario</button>            
        </div>
      </div>
    </div>
  </div>
</div>
</form>



@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')


<script>

$(document).ready(function() {
    $('.js-example-basic-single').select2();
});

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
        "info": "Mostrando la página page _PAGE_ de _PAGES_",
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