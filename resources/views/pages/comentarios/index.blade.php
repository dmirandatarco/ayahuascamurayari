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
                    <h4 class="mb-3">Listado de Comentarios</h4>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table id="agencias" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tour / Paquete</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Fecha</th>
                                    <th>Calificación</th>
                                    <th>Comentario</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comentarios as $comentario)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$comentario->comentable->nombre}}</td>
                                    <td>{{$comentario->nombre}}</td>
                                    <td>{{$comentario->email}}</td>
                                    <td>{{date("d-m-Y", strtotime($comentario->fecha))}}</td>
                                    <td>{{$comentario->calificacion}}</td>
                                    <td>{{$comentario->comentario}}</td>
                                    <td>
                                        @can('comentario.destroy')
                                        <a data-bs-toggle="tooltip" data-bs-title="Aprobar">
                                            <button type="button"  class="btn btn-success btn-icon" data-bs-toggle="modal" data-bs-target="#Eliminar" data-id="{{$comentario->id}}">
                                                <i data-feather="check"></i>
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



<div class="modal fade" id="Eliminar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Estado </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('comentario.destroy','test')}}" method="POST" autocomplete="off">
                    {{method_field('delete')}}
                    {{csrf_field()}}
                    <p>Estas seguro de cambiar el estado?</p>
                    <div class="modal-footer">
                        <input type="hidden" name="id_comentario" class="id_comentario">
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
<script>

    var eliminar = document.getElementById('Eliminar');

    eliminar.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-id')
        var idModal = eliminar.querySelector('.id_comentario')
        idModal.value = id;
    });

    $(function() {
        'use strict';

        $(function() {
            $('#agencias').DataTable({
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
