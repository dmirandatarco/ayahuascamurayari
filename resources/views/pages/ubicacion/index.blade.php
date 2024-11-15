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
                    <h4 class="mb-3">Listado de Ubicaciones</h4>
                    <div class="mb-5">
                        @can('ubicacion.create')
                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Crear" class="btn btn-primary mb-2 mb-md-0 " onclick="agregar()">
                            <i data-feather="plus-circle"></i><b> &nbsp; Crear Ubicación</b>
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
                        <table id="ubicacions" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Slug</th>
                                    <th>Descripción</th>
                                    <th>Imagen</th>
                                    <th>Idioma</th>
                                    @foreach($languages2 as $lanaguage)
                                        <th>{{$lanaguage->abreviatura}}</th>
                                    @endforeach
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ubicacions as $ubicacion)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$ubicacion->nombre}}</td>
                                    <td>{{$ubicacion->slug}}</td>
                                    <td>{{$ubicacion->descripcion}}</td>
                                    <td><img src="{{$ubicacion->image?->nombre}}" alt="{{$ubicacion->image?->nombre}}"></td>
                                    <td><img style="width:25px;" src="{{$ubicacion->language?->icono}}" alt="{{$ubicacion->language?->icono}}"></td>
                                    @foreach($languages2 as $language)
                                        <td>
                                            @php
                                                $translation = $ubicacion->traducciones->firstWhere('language_id', $language->id);
                                                $inverseTranslation = $ubicacion->traduccionesinversas->firstWhere('language_id', $language->id);
                                                $inverseTranslationespanol = $ubicacion->traduccionesinversas->firstWhere('language_id', 1);

                                                $selectedTranslation = $translation ?? (($inverseTranslation?->language_id == $language->id) ? $inverseTranslation : (($inverseTranslationespanol && $ubicacion->language_id == $language->id) ? $inverseTranslationespanol : null ));

                                            @endphp
                                            
                                            @if($selectedTranslation)
                                                <a  data-bs-toggle="tooltip" data-bs-title="{{$selectedTranslation->nombre}}">
                                                    <img style="width:25px;" src="{{$selectedTranslation->language->icono}}" alt="{{$language->icono}}">
                                                </a>
                                            @else
                                                @if($language->id==$ubicacion->language_id)
                                                    <button type="button"  data-bs-toggle="tooltip" data-bs-title="Agregar Traduccion" class="btn btn-warning btn-icon edit" onclick="traducir('{{$ubicacion->id}}','{{$ubicacion->nombre}}','{{$ubicacion->descripcion}}','1','{{$ubicacion->image?->nombre}}')">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                @else
                                                    <button type="button"  data-bs-toggle="tooltip" data-bs-title="Agregar Traduccion" class="btn btn-warning btn-icon edit" onclick="traducir('{{$ubicacion->id}}','{{$ubicacion->nombre}}','{{$ubicacion->descripcion}}','{{$language->id}}','{{$ubicacion->image?->nombre}}')">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                    <td>
                                        @can('ubicacion.edit')
                                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Editar" class="btn btn-primary btn-icon edit" onclick="editar('{{$ubicacion->id}}','{{$ubicacion->nombre}}','{{$ubicacion->descripcion}}','{{$ubicacion->language_id}}','{{$ubicacion->image?->nombre}}')">
                                            <i data-feather="edit"></i>
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
                <form action="{{route('ubicacion.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    {{csrf_field()}}
                    @include('pages.ubicacion.form')
                    <input type="hidden" name="tipoform" id="tipoform" value="{{old('tipoform')}}">
                    <input type="hidden" name="id_ubicacion" id="id_ubicacion" value="{{old('id_ubicacion')}}">
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
        $('#spanTexto').text("Crear Ubicacion");
    });
</script>
@elseif(old('tipoform')=="editar")
<script>
    $(function() {
        $('#Agregar').modal('show');
        $('#spanTexto').text("Editar Ubicacion");
    });
</script>
@else
<script>
    $(function() {
        $('#Agregar').modal('show');
        $('#spanTexto').text("Traducir Ubicacion");
    });
</script>
@endif

@endif

<script>
    function agregar() {
        $('#spanTexto').text("Crear Ubicacion");
        $('#tipoform').val("crear");
        $('#id_ubicacion').val(null);
        $('#nombre').val(null);
        $('#descripcion').val(null);
        $('#thumbnail').val(null);
        $('#language_id').val(1);
        $('#Agregar').modal('show');
    }

    function editar(id, nombre, descripcion,idioma,imagen) {
        $('#Agregar').modal('show');
        $('#spanTexto').text("Editar Ubicacion");
        $('#tipoform').val("editar");
        $('#id_ubicacion').val(id);
        $('#nombre').val(nombre);
        $('#thumbnail').val(imagen);
        $('#descripcion').val(descripcion);
        $('#language_id').val(idioma);
    }

    function traducir(id, nombre, descripcion,idioma,imagen) {
        $('#Agregar').modal('show');
        $('#spanTexto').text("Traducir Ubicacion");
        $('#tipoform').val("traducir");
        $('#id_ubicacion').val(id);
        $('#nombre').val(nombre);
        $('#thumbnail').val(imagen);
        $('#descripcion').val(descripcion);
        $('#language_id').val(idioma);
    }

    $(function() {
        'use strict';

        $(function() {
            $('#ubicacions').DataTable({
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
