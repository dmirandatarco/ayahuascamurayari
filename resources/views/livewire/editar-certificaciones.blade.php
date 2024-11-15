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
            <div class="row">
                <div class="d-md-block col col-md">
                    <div class="card-body">
                        <div class="d-grid align-items-center justify-content-between mb-2">
                            <div class="w-100" wire:ignore>
                                <label class="form-label" for="image_1">Imagen 4 Der:</label>
                                <input type="file" name="image_1" accept="image/*" id="image_1" class="form-control" wire:model='imagen1'>
                                @error('image_1')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            @if($imagen1)
                                <img src="{{$imagen1->temporaryURL()}}"  class="imagen-principal img-thumbnail">
                            @else
                                <img src="{{asset('storage/img/certificados/'.$image_1)}}"  class="imagen-principal img-thumbnail">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="d-md-block col col-md">
                    <div class="card-body">
                        <div class="d-grid align-items-center justify-content-between mb-2">
                            <div class="w-100" wire:ignore>
                                <label class="form-label" for="image_2">Imagen 3 Der:</label>
                                <input type="file" name="image_2" accept="image/*" id="image_2" class="form-control" wire:model='imagen2'>
                                @error('image_2')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            @if($imagen2)
                                <img src="{{$imagen2->temporaryURL()}}"  class="imagen-principal img-thumbnail">
                            @else
                                <img src="{{asset('storage/img/certificados/'.$image_2)}}"  class="imagen-principal img-thumbnail">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="d-md-block col col-md">
                    <div class="card-body">
                        <div class="d-grid align-items-center justify-content-between mb-2">
                            <div class="w-100" wire:ignore>
                                <label class="form-label" for="image_3">Imagen 2 Der:</label>
                                <input type="file" name="image_3" accept="image/*" id="image_3" class="form-control" wire:model='imagen3'>
                                @error('image_3')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            @if($imagen3)
                                <img src="{{$imagen3->temporaryURL()}}"  class="imagen-principal img-thumbnail">
                            @else
                                <img src="{{asset('storage/img/certificados/'.$image_3)}}"  class="imagen-principal img-thumbnail">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="d-md-block col col-md">
                    <div class="card-body">
                        <div class="d-grid align-items-center justify-content-between mb-2">
                            <div class="w-100" wire:ignore>
                                <label class="form-label" for="image_4">Imagen central:</label>
                                <input type="file" name="image_4" accept="image/*" id="image_4" class="form-control" wire:model='imagen4'>
                                @error('image_4')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            @if($imagen4)
                                <img src="{{$imagen4->temporaryURL()}}"  class="imagen-principal img-thumbnail">
                            @else
                                <img src="{{asset('storage/img/certificados/'.$image_4)}}"  class="imagen-principal img-thumbnail">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="d-md-block col col-md">
                    <div class="card-body">
                        <div class="d-grid align-items-center justify-content-between mb-2">
                            <div class="w-100" wire:ignore>
                                <label class="form-label" for="image_5">Imagen 2 Izq:</label>
                                <input type="file" name="image_5" accept="image/*" id="image_5" class="form-control" wire:model='imagen5'>
                                @error('image_5')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            @if($imagen5)
                                <img src="{{$imagen5->temporaryURL()}}"  class="imagen-principal img-thumbnail">
                            @else
                                <img src="{{asset('storage/img/certificados/'.$image_5)}}"  class="imagen-principal img-thumbnail">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="d-md-block col col-md">
                    <div class="card-body">
                        <div class="d-grid align-items-center justify-content-between mb-2">
                            <div class="w-100" wire:ignore>
                                <label class="form-label" for="image_6">Imagen 3 Izq:</label>
                                <input type="file" name="image_6" accept="image/*" id="image_6" class="form-control" wire:model='imagen6'>
                                @error('image_6')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            @if($imagen6)
                                <img src="{{$imagen6->temporaryURL()}}"  class="imagen-principal img-thumbnail">
                            @else
                                <img src="{{asset('storage/img/certificados/'.$image_6)}}"  class="imagen-principal img-thumbnail">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="d-md-block col col-md">
                    <div class="card-body">
                        <div class="d-grid align-items-center justify-content-between mb-2">
                            <div class="w-100" wire:ignore>
                                <label class="form-label" for="image_7">Imagen 4 Izq:</label>
                                <input type="file" name="image_7" accept="image/*" id="image_7" class="form-control" wire:model='imagen7'>
                                @error('image_7')
                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            @if($imagen7)
                                <img src="{{$imagen7->temporaryURL()}}"  class="imagen-principal img-thumbnail">
                            @else
                                <img src="{{asset('storage/img/certificados/'.$image_7)}}"  class="imagen-principal img-thumbnail">
                            @endif
                        </div>
                    </div>
                </div>
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
</script>


<script>
FilePond.registerPlugin(FilePondPluginFileValidateType);

// Get a reference to the file input element
const inputElement1 = document.querySelector('#image_1');


// Create a FilePond instance
const pond1 = FilePond.create(inputElement1, {
    acceptedFileTypes: ['image/*'],
    fileValidateTypeDetectType: (source, type) =>
        new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise

            resolve(type);
        }),
    }).setOptions({
    server:{
        process:(fieldName,file,metadata,load,error,progress,abort,transfer,options)=>{
            @this.upload('imagen1',file,load,error,progress)
        },

        revert:(filename,load)=>{
            @this.removeUpload('imagen1',filename,load)
        },

    },
});
</script>


<script>

FilePond.registerPlugin(FilePondPluginFileValidateType);

// Get a reference to the file input element

    const inputElement2 = document.querySelector('#image_2');

// Create a FilePond instance
const pond2 = FilePond.create(inputElement2, {
    acceptedFileTypes: ['image/*'],
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

FilePond.registerPlugin(FilePondPluginFileValidateType);

// Get a reference to the file input element

    const inputElement3 = document.querySelector('#image_3');

// Create a FilePond instance
const pond3 = FilePond.create(inputElement3, {
    acceptedFileTypes: ['image/*'],
    fileValidateTypeDetectType: (source, type) =>
        new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise

            resolve(type);
        }),
    }).setOptions({
    server:{
        process:(fieldName,file,metadata,load,error,progress,abort,transfer,options)=>{
            @this.upload('imagen3',file,load,error,progress)
        },

        revert:(filename,load)=>{
            @this.removeUpload('imagen3',filename,load)
        },

    },
});

</script>

<script>

FilePond.registerPlugin(FilePondPluginFileValidateType);

// Get a reference to the file input element

    const inputElement4 = document.querySelector('#image_4');

// Create a FilePond instance
const pond4 = FilePond.create(inputElement4, {
    acceptedFileTypes: ['image/*'],
    fileValidateTypeDetectType: (source, type) =>
        new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise

            resolve(type);
        }),
    }).setOptions({
    server:{
        process:(fieldName,file,metadata,load,error,progress,abort,transfer,options)=>{
            @this.upload('imagen4',file,load,error,progress)
        },

        revert:(filename,load)=>{
            @this.removeUpload('imagen4',filename,load)
        },

    },
});

</script>

<script>

FilePond.registerPlugin(FilePondPluginFileValidateType);

// Get a reference to the file input element

    const inputElement5 = document.querySelector('#image_5');

// Create a FilePond instance
const pond5 = FilePond.create(inputElement5, {
    acceptedFileTypes: ['image/*'],
    fileValidateTypeDetectType: (source, type) =>
        new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise

            resolve(type);
        }),
    }).setOptions({
    server:{
        process:(fieldName,file,metadata,load,error,progress,abort,transfer,options)=>{
            @this.upload('imagen5',file,load,error,progress)
        },

        revert:(filename,load)=>{
            @this.removeUpload('imagen5',filename,load)
        },

    },
});

</script>

<script>

FilePond.registerPlugin(FilePondPluginFileValidateType);

// Get a reference to the file input element

    const inputElement6 = document.querySelector('#image_6');

// Create a FilePond instance
const pond6 = FilePond.create(inputElement6, {
    acceptedFileTypes: ['image/*'],
    fileValidateTypeDetectType: (source, type) =>
        new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise

            resolve(type);
        }),
    }).setOptions({
    server:{
        process:(fieldName,file,metadata,load,error,progress,abort,transfer,options)=>{
            @this.upload('imagen6',file,load,error,progress)
        },

        revert:(filename,load)=>{
            @this.removeUpload('imagen6',filename,load)
        },

    },
});

</script>

<script>

FilePond.registerPlugin(FilePondPluginFileValidateType);

// Get a reference to the file input element

    const inputElement7 = document.querySelector('#image_7');

// Create a FilePond instance
const pond7 = FilePond.create(inputElement7, {
    acceptedFileTypes: ['image/*'],
    fileValidateTypeDetectType: (source, type) =>
        new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise

            resolve(type);
        }),
    }).setOptions({
    server:{
        process:(fieldName,file,metadata,load,error,progress,abort,transfer,options)=>{
            @this.upload('imagen7',file,load,error,progress)
        },

        revert:(filename,load)=>{
            @this.removeUpload('imagen7',filename,load)
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
