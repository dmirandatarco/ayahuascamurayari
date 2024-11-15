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
                    <h4 class="mb-3">Listado de Endoses Out</h4>
                    <div class="mb-5">
                        @can('endoseout.create')
                        <a href="{{ route('endoseout.create')}}">
                            <button type="button"  data-bs-toggle="tooltip" data-bs-title="Crear" class="btn btn-primary mb-2 mb-md-0 ">
                                <i data-feather="plus-circle"></i><b> &nbsp; Crear Endonse Out</b>
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
                        <table id="reservas" class="table">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>FECHA</th>
                                    <th>TOUR</th>
                                    <th>AGENCIA</th>
                                    <th>USUARIO</th>
                                    <th>CANTIDAD</th>
                                    <th>COSTO</th>
                                    <th>ESTADO</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($operars as $operar)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td> {{date("d-m-Y", strtotime($operar->fecha))}}</td>
                                    <td>{{$operar->tour->nombre}}</td>
                                    <td>{{$operar->proveedors[0]->nombre}}</td>
                                    <td>{{$operar->user->nombre}}</td>
                                    <td>{{$operar->cantidad}}</td>
                                    <td>{{$operar->precio}}</td>
                                    <td>
                                        @if($operar->estado==1)
                                        Registrado
                                        @else
                                        Anulado
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('endoseout.mensaje',$operar) }}" target="_blank">
                                            <button type="button"  data-bs-toggle="tooltip" data-bs-title="Enviar" class="btn btn-success btn-icon">
                                                <i data-feather="send"></i>
                                            </button>
                                        </a>
                                        @can('endoseout.ver')
                                        <a href="{{ route('endoseout.ver',$operar) }}">
                                            <button type="button"  data-bs-toggle="tooltip" data-bs-title="Ver" class="btn btn-warning btn-icon">
                                                <i data-feather="eye"></i>
                                            </button>
                                        </a>
                                        @endcan
                                        @can('endoseout.edit')
                                        <a href="{{ route('endoseout.edit',$operar) }}">
                                            <button type="button"  data-bs-toggle="tooltip" data-bs-title="Editar" class="btn btn-primary btn-icon">
                                                <i data-feather="edit"></i>
                                            </button>
                                        </a>
                                        @endcan
                                        @can('endoseout.destroy')
                                        <button type="button" class="btn btn-danger btn-icon" data-bs-toggle="modal" data-bs-target="#EliminarUsuario" data-id="{{$operar->id}}">
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

<div class="modal fade" id="EliminarUsuario" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Estado de Endose</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('endoseinn.destroy','test')}}" method="POST" autocomplete="off">
                    {{method_field('delete')}}
                    {{csrf_field()}}
                    <p>¿Estás seguro de cambiar el estado?</p>
                    <div class="modal-footer">
                        <input type="hidden" name="id_endoseout_2" class="id_endoseout_2">
                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cerrar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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

        eliminarUsuario.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget

            var id = button.getAttribute('data-id')

            var idModal = eliminarUsuario.querySelector('.id_endoseout_2')

            idModal.value = id;
        })

        $(function() {
            'use strict';

            $(function() {
                $('#reservas').DataTable({
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
                        targets: [8],
                        orderable: false
                    }]
                });
            });

        });
    </script>
    @endpush
