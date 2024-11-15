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
                    <h4 class="mb-3">Listado de Categorias</h4>
                    <div class="mb-5">
                        @can('categoria.create')
                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Crear" class="btn btn-primary mb-2 mb-md-0 " onclick="agregar()">
                            <i data-feather="plus-circle"></i><b> &nbsp; Crear Categoria</b>
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
                        <table id="categorias" class="table">
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
                                @foreach($categorias as $categoria)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$categoria->nombre}}</td>
                                    <td>{{$categoria->slug}}</td>
                                    <td>{{$categoria->descripcion}}</td>
                                    <td><img src="{{$categoria->image?->nombre}}" alt="{{$categoria->image?->nombre}}"></td>
                                    <td><img style="width:25px;" src="{{$categoria->language?->icono}}" alt="{{$categoria->language?->icono}}"></td>
                                    @foreach($languages2 as $language)
                                        <td>
                                            @php
                                                $translation = $categoria->traducciones->firstWhere('language_id', $language->id);
                                                $inverseTranslation = $categoria->traduccionesinversas->firstWhere('language_id', $language->id);
                                                $inverseTranslationespanol = $categoria->traduccionesinversas->firstWhere('language_id', 1);

                                                $selectedTranslation = $translation ?? (($inverseTranslation?->language_id == $language->id) ? $inverseTranslation : (($inverseTranslationespanol && $categoria->language_id == $language->id) ? $inverseTranslationespanol : null ));                                            
                                            @endphp
                                            
                                            @if($selectedTranslation)
                                                <a  data-bs-toggle="tooltip" data-bs-title="{{$selectedTranslation->nombre}}">
                                                    <img style="width:25px;" src="{{$selectedTranslation->language->icono}}" alt="{{$language->icono}}">
                                                </a>
                                            @else
                                                @if($language->id==$categoria->language_id)
                                                    <button type="button"  data-bs-toggle="tooltip" data-bs-title="Agregar Traduccion" class="btn btn-warning btn-icon edit" onclick="traducir('{{$categoria->id}}','{{$categoria->nombre}}','{{$categoria->descripcion}}','1','{{$categoria->image?->nombre}}')">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                @else
                                                    <button type="button"  data-bs-toggle="tooltip" data-bs-title="Agregar Traduccion" class="btn btn-warning btn-icon edit" onclick="traducir('{{$categoria->id}}','{{$categoria->nombre}}','{{$categoria->descripcion}}','{{$language->id}}','{{$categoria->image?->nombre}}')">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                    <td>
                                        @can('categoria.edit')
                                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Editar" class="btn btn-primary btn-icon edit" onclick="editar('{{$categoria->id}}','{{$categoria->nombre}}','{{$categoria->descripcion}}','{{$categoria->language_id}}','{{$categoria->image?->nombre}}')">
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
                <form action="{{route('categoria.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    {{csrf_field()}}
                    @include('pages.categoria.form')
                    <input type="hidden" name="tipoform" id="tipoform" value="{{old('tipoform')}}">
                    <input type="hidden" name="id_categoria" id="id_categoria" value="{{old('id_categoria')}}">
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
        $('#spanTexto').text("Crear Categoria");
    });
</script>
@elseif(old('tipoform')=="editar")
<script>
    $(function() {
        $('#Agregar').modal('show');
        $('#spanTexto').text("Editar Categoria");
    });
</script>
@else
<script>
    $(function() {
        $('#Agregar').modal('show');
        $('#spanTexto').text("Traducir Categoria");
    });
</script>
@endif

@endif

<script>
    function agregar() {
        $('#spanTexto').text("Crear Categoria");
        $('#tipoform').val("crear");
        $('#id_categoria').val(null);
        $('#nombre').val(null);
        $('#thumbnail').val(null);
        $('#descripcion').val(null);
        $('#language_id').val(1);
        $('#Agregar').modal('show');
    }

    function editar(id, nombre, descripcion,idioma,imagen) {
        $('#Agregar').modal('show');
        $('#spanTexto').text("Editar Categoria");
        $('#tipoform').val("editar");
        $('#id_categoria').val(id);
        $('#nombre').val(nombre);
        $('#thumbnail').val(imagen);
        $('#descripcion').val(descripcion);
        $('#language_id').val(idioma);
    }

    function traducir(id, nombre, descripcion,idioma,imagen) {
        $('#Agregar').modal('show');
        $('#spanTexto').text("Traducir Categoria");
        $('#tipoform').val("traducir");
        $('#id_categoria').val(id);
        $('#nombre').val(nombre);
        $('#thumbnail').val(imagen);
        $('#descripcion').val(descripcion);
        $('#language_id').val(idioma);
    }

    $(function() {
        'use strict';

        $(function() {
            $('#categorias').DataTable({
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
