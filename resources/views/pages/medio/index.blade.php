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
                    <h4 class="mb-3">Listado de Medios de Pago</h4>
                    <div class="mb-5">
                        @can('medio.create')
                        <button type="button" data-bs-toggle="tooltip" data-bs-title="Crear" class="btn btn-primary mb-2 mb-md-0 " onclick="agregar()">
                            <i data-feather="plus-circle"></i><b> &nbsp; Crear Medio de Pago</b>
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
                                <tr>
                                    <th>Numero</th>
                                    <th>Nombre</th>
                                    <th>Numero</th>
                                    <th>Descripcion</th>
                                    <th>Moneda</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($medios as $medio)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$medio->nombre}}</td>
                                    <td>{{$medio->numero}}</td>
                                    <td>{{$medio->descripcion}}</td>
                                    <td>{{$medio->moneda->nombre}}</td>
                                    <td>
                                        @if($medio->estado==1)
                                        Activo
                                        @else
                                        Inactivo
                                        @endif
                                    </td>
                                    <td>
                                        @can('medio.edit')
                                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Editar" class="btn btn-primary btn-icon edit" onclick="editar('{{$medio->id}}','{{$medio->nombre}}','{{$medio->numero}}','{{$medio->descripcion}}','{{$medio->moneda_id}}')">
                                            <i data-feather="edit"></i>
                                        </button>
                                        @endcan
                                        @can('medio.destroy')
                                        <button type="button" class="btn btn-danger btn-icon" data-bs-toggle="modal" data-bs-target="#Eliminar" data-id="{{$medio->id}}">
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
                <h5 class="modal-title" id="spanTexto"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('medio.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    {{csrf_field()}}
                    @include('pages.medio.form')
                    <input type="hidden" name="tipoform" id="tipoform">
                    <input type="hidden" name="id_medio" id="id_medio" class="id_medio" value="{{old('id_medio')}}">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Eliminar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Estado </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('medio.destroy','test')}}" method="POST" autocomplete="off">
                    {{method_field('delete')}}
                    {{csrf_field()}}
                    <p>Estas seguro de cambiar el estado?</p>
                    <div class="modal-footer">
                        <input type="hidden" name="id_medio_2" class="id_medio_2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
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
        $('#spanTexto').text("Crear Medio de Pago");
    });
</script>
@else
<script>
    $(function() {
        $('#Agregar').modal('show');
        $('#spanTexto').text("Editar Medio de Pago");
    });
</script>
@endif

@endif

<script>
    $(document).ready(function() {
        $("#moneda_id").select2({
            dropdownParent: $("#Agregar"),
            width: '100%'
        });
    })

    function agregar() {
        $('#spanTexto').text("Crear Medio de Pago");
        $('#tipoform').val("crear");
        $('#id_medio').val(null);
        $('#nombre').val(null);
        $('#numero').val(null);
        $('#descripcion').val(null);
        $('#moneda_id').select2('destroy');
        $('#moneda_id').val(null).select2({
            dropdownParent: $("#Agregar"),
            width: '100%'
        });
        $('#Agregar').modal('show');
    }

    function editar(id, nombre, numero, descripcion, moneda_id) {
        $('#Agregar').modal('show');
        $('#spanTexto').text("Editar Medio de Pago");
        $('#tipoform').val("editar");
        $('#id_medio').val(id);
        $('#nombre').val(nombre);
        $('#numero').val(numero);
        $('#descripcion').val(descripcion);
        $('#moneda_id').select2('destroy');
        $('#moneda_id').val(moneda_id).select2({
            dropdownParent: $("#Agregar"),
            width: '100%'
        });
    }

    var eliminar = document.getElementById('Eliminar');

    eliminar.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-id')
        var idModal = eliminar.querySelector('.id_medio_2')
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
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior",
                    }
                },
                "columnDefs": [{
                    targets: [6],
                    orderable: false
                }]
            });
        });

    });
</script>
@endpush
