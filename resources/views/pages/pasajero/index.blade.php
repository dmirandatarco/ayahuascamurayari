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
                    <h4 class="mb-3">Listado de Pasajeros</h4>
                    <div class="mb-5">
                        @can('pasajero.create')
                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Crear" class="btn btn-primary mb-2 mb-md-0 " onclick="agregar()">
                            <i data-feather="plus-circle"></i><b> &nbsp; Crear Pasajero</b>
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
                        <table id="pasajeros" class="table">
                            <thead>
                                <tr>
                                    <th>Numero</th>
                                    <th>Nombre</th>
                                    <th>Tipo Documento</th>
                                    <th>Nº Documento</th>
                                    <th>Celular</th>
                                    <th>E-mail</th>
                                    <th>Pais</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pasajeros as $chunk)
                                @foreach($chunk as $pasajero)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$pasajero->nombre}}</td>
                                    <td>{{$pasajero->tipo_documento}}</td>
                                    <td>{{$pasajero->num_documento}}</td>
                                    <td>{{$pasajero->celular}}</td>
                                    <td>{{$pasajero->email}}</td>
                                    <td>{{$pasajero->pais->nombre}}</td>
                                    <td>
                                        @can('pasajero.edit')
                                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Editar" class="btn btn-primary btn-icon" onclick="editar('{{$pasajero->id}}','{{$pasajero->nombre}}','{{$pasajero->tipo_documento}}','{{$pasajero->num_documento}}','{{$pasajero->celular}}','{{$pasajero->email}}','{{$pasajero->pais_id}}')">
                                            <i data-feather="edit"></i>
                                        </button>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
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
                <form action="{{route('pasajero.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    {{csrf_field()}}
                    @include('pages.pasajero.form')
                    <input type="hidden" name="tipoform" id="tipoform">
                    <input type="hidden" name="id_pasajero" id="id_pasajero" class="id_pasajero" value="{{old('id_pasajero')}}">
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
        $('#spanTexto').text("Crear Pasajero");
    });
</script>
@else
<script>
    $(function() {
        $('#Agregar').modal('show');
        $('#spanTexto').text("Editar Pasajero");
    });
</script>
@endif

@endif

<script>
    $(document).ready(function() {
        $("#pais_id").select2({
            dropdownParent: $("#Agregar"),
            width: '100%'
        });
    })

    $(document).ready(function() {
        $("#tipo_documento").select2({
            dropdownParent: $("#Agregar"),
            width: '100%'
        });
    })

    function agregar() {
        $('#spanTexto').text("Crear Pasajero");
        $('#tipoform').val("crear");
        $('#id_pasajero').val(null);
        $('#nombre').val(null);
        $('#tipo_documento').select2('destroy');
        $('#tipo_documento').val(null).select2({
            dropdownParent: $("#Agregar"),
            width: '100%'
        });
        $('#num_documento').val(null);
        $('#celular').val(null);
        $('#email').val(null);
        $('#pais_id').select2('destroy');
        $('#pais_id').val(null).select2({
            dropdownParent: $("#Agregar"),
            width: '100%'
        });
        $('#Agregar').modal('show');
    }

    function editar(id, nombre, tipo_documento, num_documento, celular, email, pais_id) {
        $('#Agregar').modal('show');
        $('#spanTexto').text("Editar Pasajero");
        $('#tipoform').val("editar");
        $('#id_pasajero').val(id);
        $('#nombre').val(nombre);
        $('#tipo_documento').select2('destroy');
        $('#tipo_documento').val(tipo_documento).select2({
            dropdownParent: $("#Agregar"),
            width: '100%'
        });
        $('#num_documento').val(num_documento);
        $('#celular').val(celular);
        $('#email').val(email);
        $('#pais_id').select2('destroy');
        $('#pais_id').val(pais_id).select2({
            dropdownParent: $("#Agregar"),
            width: '100%'
        });
    }

    $(function() {
        'use strict';

        $(function() {
            $('#pasajeros').DataTable({
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
                    targets: [7],
                    orderable: false
                }]
            });
        });

    });
</script>
@endpush
