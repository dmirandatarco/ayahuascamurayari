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
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="w-100" wire:ignore>
                                <label class="form-label" for="image_principal">Imagen Principal:</label>
                                <input type="file" name="image_principal" id="image_principal" class="form-control" wire:model='imagen'>
                                @error('image_principal')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                                @if($imagen)
                                    <img src="{{$imagen->temporaryURL()}}"  class="imagen-principal img-thumbnail w-25">
                                @else
                                    <img src="{{$image_principal}}"  class="imagen-principal img-thumbnail w-25">
                                @endif
                        </div>
                    </div>
                </div>

                <div class="d-md-block col-md-12 col-xl-6">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="w-100" wire:ignore>
                                <label class="form-label" for="image_secundaria">Imagen Secundaria:</label>
                                <input type="file" name="image_secundaria" id="image_secundaria" class="form-control" wire:model='imagen2'>
                                @error('image_secundaria')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                                @if($imagen2)
                                    <img src="{{$imagen2->temporaryURL()}}"  class="imagen-principal img-thumbnail w-25">
                                @else
                                    <img src="{{$image_secundaria}}"  class="imagen-principal img-thumbnail w-25">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="d-md-block col-md-12 col-xl-6">
                    <div class="card-body">
                        <label class="form-label" for="titulo">Titulo:</label>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <input type="text" class="form-control" name="titulo" placeholder="Nosotros somos Day Expeditions Travel" id="titulo" wire:model.defer="titulo">
                        </div>
                    </div>
                </div>
                <div class="d-md-block col-md-12 col-xl-6">
                    <div class="card-body">
                        <label class="form-label" for="subtitulo">Subtitulo:</label>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <input type="text" class="form-control" name="subtitulo" placeholder="CREANDO EXPERIENCIAS INOLVIDABLES" id="subtitulo" wire:model.defer="subtitulo">
                        </div>
                    </div>
                </div>
                <div class="d-md-block col-md-12 col-xl-12">
                    <div class="card-body"wire:ignore>
                        <label class="form-label" for="descripcion">Descripción:</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="10" wire:model.defer="descripcion"></textarea>
                    </div>
                </div>
                <div class="d-md-block col-md-4 col-xl-4">
                    <div class="card-body"wire:ignore>
                        <label class="form-label" for="descripcion1">Descripción 1:</label>
                        <textarea class="form-control" name="descripcion1" id="descripcion1" rows="10" wire:model.defer="descripcion1"></textarea>
                    </div>
                </div>
                <div class="d-md-block col-md-4 col-xl-4">
                    <div class="card-body"wire:ignore>
                        <label class="form-label" for="descripcion2">Descripción 2:</label>
                        <textarea class="form-control" name="descripcion2" id="descripcion2" rows="10" wire:model.defer="descripcion2"></textarea>
                    </div>
                </div>
                <div class="d-md-block col-md-4 col-xl-4">
                    <div class="card-body"wire:ignore>
                        <label class="form-label" for="descripcion3">Descripción 3:</label>
                        <textarea class="form-control" name="descripcion3" id="descripcion3" rows="10" wire:model.defer="descripcion3"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="d-md-block col-md-6 col-xl-3">
                    <div class="card-body">
                        <label class="form-label" for="num_viajes">N° Viajes:</label>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <input type="text" class="form-control" name="num_viajes" placeholder="+999" id="num_viajes" wire:model.defer="num_viajes">
                        </div>
                    </div>
                </div>
                <div class="d-md-block col-md-6 col-xl-3">
                    <div class="card-body">
                        <label class="form-label" for="num_clientes">N° Cliente:</label>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <input type="text" class="form-control" name="num_clientes" placeholder="+999" id="num_clientes" wire:model.defer="num_clientes">
                        </div>
                    </div>
                </div>
                <div class="d-md-block col-md-6 col-xl-3">
                    <div class="card-body">
                        <label class="form-label" for="num_miembros">N° Miembros:</label>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <input type="text" class="form-control" name="num_miembros" placeholder="+999" id="num_miembros" wire:model.defer="num_miembros">
                        </div>
                    </div>
                </div>
                <div class="d-md-block col-md-6 col-xl-3">
                    <div class="card-body">
                        <label class="form-label" for="num_reconocimientos">N° Reconocimientos:</label>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <input type="text" class="form-control" name="num_reconocimientos" placeholder="+999" id="num_reconocimientos" wire:model.defer="num_reconocimientos">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="d-md-block col-md-12 col-xl-12">
                    <div class="card-body">
                        <label class="form-label" for="galeria">Galeria:</label>
                        <div>
                            <div wire:ignore>
                                <input type="file" name="galeria[]" id="galeria" class="form-control" wire:model='imagenesgaleria' multiple>
                                @error('galeria')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            @if($galeria)
                                @foreach($galeria as $i => $image)
                                    <button class="badge btn-danger position-absolute mt-2 ms-2" wire:click.prevent="eliminarfotos({{$i}})">X</button>
                                    <img src="{{$image->nombre}}"  class="imagen-principal">
                                @endforeach
                            @endif
                            @if($imagenesgaleria)
                                @foreach($imagenesgaleria as $imag)
                                    <img src="{{$imag->temporaryURL()}}"  class="imagen-principal mr-2">
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="language_id" wire:model="language_id">
            <input type="hidden" name="nosotros_id" wire:model="nosotros_id">
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


<script>
document.addEventListener('livewire:load', function () {
    ClassicEditor
    .create( document.querySelector( '#descripcion' ),{
    language: 'es',
    })
    .then(editor => {
        editor.model.document.on('change:data', () => {
        @this.set('descripcion', editor.getData());
        }),
        editor.keystrokes.set( 'space', ( key, stop ) => {
            editor.execute( 'input', { text: '\u00a0' } );
            stop();
        } );
    })
    .catch( error => {
        console.error( error );
    } );
});

document.addEventListener('livewire:load', function () {
    ClassicEditor
    .create( document.querySelector( '#descripcion1' ),{
    language: 'es',
    })
    .then(editor => {
        editor.model.document.on('change:data', () => {
        @this.set('descripcion1', editor.getData());
        }),
        editor.keystrokes.set( 'space', ( key, stop ) => {
            editor.execute( 'input', { text: '\u00a0' } );
            stop();
        } );
    })
    .catch( error => {
        console.error( error );
    } );
});

document.addEventListener('livewire:load', function () {
    ClassicEditor
    .create( document.querySelector( '#descripcion2' ),{
    language: 'es',
    })
    .then(editor => {
        editor.model.document.on('change:data', () => {
        @this.set('descripcion2', editor.getData());
        }),
        editor.keystrokes.set( 'space', ( key, stop ) => {
            editor.execute( 'input', { text: '\u00a0' } );
            stop();
        } );
    })
    .catch( error => {
        console.error( error );
    } );
});

document.addEventListener('livewire:load', function () {
    ClassicEditor
    .create( document.querySelector( '#descripcion3' ),{
    language: 'es',
    })
    .then(editor => {
        editor.model.document.on('change:data', () => {
        @this.set('descripcion3', editor.getData());
        }),
        editor.keystrokes.set( 'space', ( key, stop ) => {
            editor.execute( 'input', { text: '\u00a0' } );
            stop();
        } );
    })
    .catch( error => {
        console.error( error );
    } );
});
</script>

<script>

// Get a reference to the file input element
const inputElement2 = document.querySelector('#galeria');


// Create a FilePond instance
const pond2 = FilePond.create(inputElement2, {
    fileValidateTypeDetectType: (source, type) =>
        new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise

            resolve(type);
        }),
    }).setOptions({
    server:{
        process:(fieldName,file,metadata,load,error,progress,abort,transfer,options)=>{
            @this.upload('imagenesgaleria',file,load,error,progress)
        },

        revert:(filename,load)=>{
            @this.removeUpload('imagenesgaleria',filename,load)
        },

    },
});



</script>

<script>
FilePond.registerPlugin(FilePondPluginFileValidateType);

// Get a reference to the file input element
const inputElement = document.querySelector('#image_principal');


// Create a FilePond instance
const pond = FilePond.create(inputElement, {
    
    fileValidateTypeDetectType: (source, type) =>
        new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise

            resolve(type);
        }),
    }).setOptions({
    server:{
        process:(fieldName,file,metadata,load,error,progress,abort,transfer,options)=>{
            @this.upload('imagen',file,load,error,progress)
        },

        revert:(filename,load)=>{
            @this.removeUpload('imagen',filename,load)
        },
    },
});
</script>


<script>

FilePond.registerPlugin(FilePondPluginFileValidateType);

// Get a reference to the file input element

    const inputElement3 = document.querySelector('#image_secundaria');

// Create a FilePond instance
const pond3 = FilePond.create(inputElement3, {
    fileValidateTypeDetectType: (source, type) =>
        new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise

            resolve(type);
        }),
    }).setOptions({
    server:{
        process:(fieldName,file,metadata,load,error,progress,abort,transfer,options)=>{
            @this.upload('imagen2',file,load,error,progress)
        },

        revert:(filename,load)=>{
            @this.removeUpload('imagen2',filename,load)
        },

    },
});

</script>


<script>
const labels_es_ES = {
    labelIdle: 'Arrastra y suelta tus archivos o <span class = "filepond--label-action"> Examinar <span>',
    labelInvalidField: "El campo contiene archivos inválidos",
    labelFileWaitingForSize: "Esperando tamaño",
    labelFileSizeNotAvailable: "Tamaño no disponible",
    labelFileLoading: "Cargando",
    labelFileLoadError: "Error durante la carga",
    labelFileProcessing: "Cargando",
    labelFileProcessingComplete: "Carga completa",
    labelFileProcessingAborted: "Carga cancelada",
    labelFileProcessingError: "Error durante la carga",
    labelFileProcessingRevertError: "Error durante la reversión",
    labelFileRemoveError: "Error durante la eliminación",
    labelTapToCancel: "toca para cancelar",
    labelTapToRetry: "tocar para volver a intentar",
    labelTapToUndo: "tocar para deshacer",
    labelButtonRemoveItem: "Eliminar",
    labelButtonAbortItemLoad: "Abortar",
    labelButtonRetryItemLoad: "Reintentar",
    labelButtonAbortItemProcessing: "Cancelar",
    labelButtonUndoItemProcessing: "Deshacer",
    labelButtonRetryItemProcessing: "Reintentar",
    labelButtonProcessItem: "Cargar",
    labelMaxFileSizeExceeded: "El archivo es demasiado grande",
    labelMaxFileSize: "El tamaño máximo del archivo es {filesize}",
    labelMaxTotalFileSizeExceeded: "Tamaño total máximo excedido",
    labelMaxTotalFileSize: "El tamaño total máximo del archivo es {filesize}",
    labelFileTypeNotAllowed: "Archivo de tipo no válido",
    fileValidateTypeLabelExpectedTypes: "Espera {allButLastType} o {lastType}",
    imageValidateSizeLabelFormatError: "Tipo de imagen no compatible",
    imageValidateSizeLabelImageSizeTooSmall: "La imagen es demasiado pequeña",
    imageValidateSizeLabelImageSizeTooBig: "La imagen es demasiado grande",
    imageValidateSizeLabelExpectedMinSize: "El tamaño mínimo es {minWidth} × {minHeight}",
    imageValidateSizeLabelExpectedMaxSize: "El tamaño máximo es {maxWidth} × {maxHeight}",
    imageValidateSizeLabelImageResolutionTooLow: "La resolución es demasiado baja",
    imageValidateSizeLabelImageResolutionTooHigh: "La resolución es demasiado alta",
    imageValidateSizeLabelExpectedMinResolution: "La resolución mínima es {minResolution}",
    imageValidateSizeLabelExpectedMaxResolution: "La resolución máxima es {maxResolution}",
};

FilePond.setOptions(labels_es_ES);

</script>
@endpush
