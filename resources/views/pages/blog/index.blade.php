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
                    <h4 class="mb-3">Listado de Blogs</h4>
                    <div class="mb-5">
                        @can('blog.create')
                        <a href="{{ route('blog.create')}}">
                            <button type="button"  data-bs-title="Crear" class="btn btn-primary mb-2 mb-md-0 ">
                                <i data-feather="plus-circle"></i><b> &nbsp; Crear Blog</b>
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
                        <table id="categorias" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Titulo</th>
                                    <th>Fecha</th>
                                    <th>Autor</th>
                                    <th>Imagen</th>
                                    <th>Idioma</th>
                                    @foreach($languages2 as $lanaguage)
                                        <th>{{$lanaguage->abreviatura}}</th>
                                    @endforeach
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogs as $blog)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$blog->titulo}}</td>
                                    <td>{{$blog->fecha}}</td>
                                    <td>{{$blog->user->nombre}}</td>
                                    <td><img src="{{$blog->imagenprincipal}}" alt="{{$blog->imagenprincipal}}"></td>
                                    <td><img style="width:25px;" src="{{$blog->language?->icono}}" alt="{{$blog->language?->icono}}"></td>
                                    @foreach($languages2 as $language)
                                        <td>
                                            @php
                                                $translation = $blog->traducciones->firstWhere('language_id', $language->id);
                                                $inverseTranslation = $blog->traduccionesinversas->firstWhere('language_id', $language->id);
                                                $inverseTranslationespanol = $blog->traduccionesinversas->firstWhere('language_id', 1);

                                                $selectedTranslation = $translation ?? (($inverseTranslation?->language_id == $language->id) ? $inverseTranslation : (($inverseTranslationespanol && $blog->language_id == $language->id) ? $inverseTranslationespanol : null ));                                            
                                            @endphp
                                            
                                            @if($selectedTranslation)
                                                <a  data-bs-toggle="tooltip" data-bs-title="{{$selectedTranslation->titulo}}" href="{{ route('blog.edit',$selectedTranslation) }}">
                                                    <img style="width:25px;" src="{{$selectedTranslation->language->icono}}" alt="{{$language->icono}}">
                                                </a>
                                            @else
                                                <a href="{{ route('blog.traducir',['lang'=>$language->id,'blog'=>$blog]) }}">
                                                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Agregar Traduccion" class="btn btn-warning btn-icon edit">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                                </a>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td>
                                        @can('blog.edit')
                                            <a href="{{ route('blog.edit',$blog) }}">
                                                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Editar" class="btn btn-primary btn-icon edit" >
                                                    <i data-feather="edit"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('blog.destroy')
                                            <button type="button" class="btn btn-danger btn-icon" data-bs-toggle="modal" data-bs-target="#EliminarUsuario" data-id="{{$blog->id}}">
                                                <i  data-bs-toggle="tooltip" data-bs-title="Eliminar" data-feather="lock"></i>
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

<div class="modal fade" id="EliminarUsuario"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Cambiar Estado de Blog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
        <div class="modal-body">
            <form action="{{route('blog.destroy','test')}}" method="POST" autocomplete="off">
            {{method_field('delete')}}
            {{csrf_field()}}
                <p>¿Estás seguro de cambiar el estado?</p>
                <div class="modal-footer">
                    <input type="hidden" name="id_blog_2" class="id_blog_2">
                    <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cancelar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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

eliminarUsuario.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget

    var id = button.getAttribute('data-id')

    var idModal = eliminarUsuario.querySelector('.id_blog_2')

    idModal.value = id;
})

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
