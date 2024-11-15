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
                    <h4 class="mb-3">Listado de Idiomas</h4>
                    <div class="mb-5">
                        @can('language.create')
                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Crear" class="btn btn-primary mb-2 mb-md-0 " onclick="agregar()">
                            <i data-feather="plus-circle"></i><b> &nbsp; Crear Idioma</b>
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
                        <table id="idiomas" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Icono</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($idiomas as $idioma)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$idioma->abreviatura}}</td>
                                    <td><img class="wd-30 ht-30" src="{{$idioma->icono}}" alt="" style="height: 30px;"></td>
                                    <td>{{$idioma->estado ? 'Activo' : 'Inactivo'}}</td>
                                    <td>
                                        @can('language.edit')
                                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Editar" class="btn btn-primary btn-icon edit" onclick="editar('{{$idioma->id}}','{{$idioma->abreviatura}}')">
                                            <i data-feather="edit"></i>
                                        </button>
                                        @endcan
                                        @can('language.destroy')
                                        <button type="button" class="btn btn-danger btn-icon" data-bs-toggle="modal" data-bs-target="#Eliminar" data-id="{{$idioma->id}}">
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
                <form action="{{route('language.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    {{csrf_field()}}
                    @include('pages.idioma.form')
                    <input type="hidden" name="tipoform" id="tipoform" value="{{old('tipoform')}}">
                    <input type="hidden" name="id_idioma" id="id_idioma" class="id_idioma" value="{{old('id_idioma')}}">
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
                <form action="{{route('language.destroy','test')}}" method="POST" autocomplete="off">
                    {{method_field('delete')}}
                    {{csrf_field()}}
                    <p>Estas seguro de cambiar el estado?</p>
                    <div class="modal-footer">
                        <input type="hidden" name="id_idioma_2" class="id_idioma_2">
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
            $('#spanTexto').text("Crear Idioma");
        });
    </script>
    @else
    <script>
        $(function() {
            $('#Agregar').modal('show');
            $('#spanTexto').text("Editar Idioma");
        });
    </script>
    @endif
@endif

<script>
    function agregar() {
        $('#spanTexto').text("Crear Idioma");
        $('#tipoform').val("crear");
        $('#id_idioma').val(null);
        $('#abreviatura').val(null);
        $('#thumbnail').val(null);
        $('#Agregar').modal('show');
    }

    function editar(id, abreviatura,imagen) {
        $('#Agregar').modal('show');
        $('#spanTexto').text("Editar Idioma");
        $('#tipoform').val("editar");
        $('#thumbnail').val(imagen);
        $('#id_idioma').val(id);
        $('#abreviatura').val(abreviatura);
    }

    var eliminar = document.getElementById('Eliminar');

    eliminar.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-id')
        var idModal = eliminar.querySelector('.id_idioma_2')
        idModal.value = id;
    });

    $(function() {
        'use strict';

        $(function() {
            $('#idiomas').DataTable({
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
                    targets: [4],
                    orderable: false
                }]
            });
        });

    });
</script>
@endpush
