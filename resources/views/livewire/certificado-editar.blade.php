@push('plugin-styles')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/filepond/filepond.css') }}" rel="stylesheet" />
@endpush
<div class="row">
    <form action="{{route('cabecera.store')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="card rounded">
            <div class="row">
                <div class="d-md-block col-md-12 col-xl-6">
                    <div class="card-body">
                        <label class="form-label" for="titulo">Titulo:</label>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <input type="text" class="form-control" name="titulo" placeholder="Nosotros somos Day Expeditions Travel" id="titulo" wire:model="titulo">
                        </div>
                    </div>
                </div>
                <div class="d-md-block col-md-12 col-xl-6">
                    <div class="card-body">
                        <label class="form-label" for="subtitulo">Subtitulo:</label>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <input type="text" class="form-control" name="subtitulo" placeholder="CREANDO EXPERIENCIAS INOLVIDABLES" id="subtitulo" wire:model="subtitulo">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <span class="h4">Certificados</span>
                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Agregar" class="btn btn-success " wire:click="aumentar"> 
                    <i class="fa fa-plus-circle"></i> Agregar
                </button>
            </div>
            <div class="row">
                @for($i = 0; $i < $cont; $i++)
                    <div class="d-md-block col col-md-3">
                        <div class="card-body">
                            <label class="form-label" for="galeria">Icono:</label>
                            <div>
                                <div wire:ignore>
                                    <input type="file" id="url{{$i}}" wire:model.defer="url.{{$i}}" class="form-control" >
                                    @error('url.'.$i)
                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-md-block col col-md-2">
                        @if(isset($url[$i]))
                            <img src="{{$url[$i]->temporaryURL()}}"  class="imagen-principal mr-2">
                        @else
                            @if(isset($urlanterior[$i]))
                                <img src="{{$urlanterior[$i]}}"  class="imagen-principal">
                            @endif
                        @endif
                    </div>
                    <div class="d-md-block col col-md-3">
                        <div class="card-body">
                            <label class="form-label" for="galeria">Foto Mostrar:</label>
                            <div>
                                <div wire:ignore>
                                    <input type="file" id="urlabrir{{$i}}" wire:model.defer="urlabrir.{{$i}}" class="form-control" >
                                    @error('urlabrir.'.$i)
                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-md-block col col-md-2">
                        @if(isset($urlabrir[$i]))
                            <img src="{{$urlabrir[$i]->temporaryURL()}}"  class="imagen-principal mr-2">
                        @else
                            @if(isset($urlabriranterior[$i]))
                                <img src="{{$urlabriranterior[$i]}}"  class="imagen-principal">
                            @endif
                        @endif
                    </div>
                    <div class="d-md-block col col-md-2 mt-5">
                        <button type="button" data-bs-toggle="tooltip" data-bs-title="Reducir" class="btn btn-danger btn-icon" wire:click="reducir({{$i}})">-</button>
                    </div>
                @endfor
            </div>
            
            <input type="hidden" name="language_id" wire:model="language_id">
            <input type="hidden" name="certificado_id" wire:model="certificado_id">
        </div>
        <button type="button" class="btn btn-primary" wire:click.prevent="register">Guardar</button>

    </form>

</div>
@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/plugins/ckeditor/es.js') }}"></script>
    <script src="{{ asset('assets/plugins/filepond/filepond.js') }}"></script>
    <script src="{{ asset('assets/plugins/filepond/filepond-validation.js') }}"></script>
@endpush

@push('custom-scripts')
@endpush
