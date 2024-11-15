<div class="row">
    <div class="mb-3 col-md-8" wire:ignore>
        <label class="form-label" for="imagenmapa">Imagen Mapa:</label>
        <input type="file" name="imagenmapa" id="imagenmapa" class="form-control" wire:model='imagenmapa'>
        @error('imagenmapa')
            <span class="error-message" style="color:red">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-3 col-md-4">
        @if($imagenmapa)
            <img src="{{$imagenmapa->temporaryURL()}}"  class="imagen-principal">
        @endif
    </div>
</div>

@push('custom-scripts')
<script>
FilePond.registerPlugin(FilePondPluginFileValidateType);

// Get a reference to the file input element
const inputElement1 = document.querySelector('#imagenmapa');


// Create a FilePond instance
const pond1 = FilePond.create(inputElement1, {
    fileValidateTypeDetectType: (source, type) =>
        new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise

            resolve(type);
        }),
    }).setOptions({
    server:{
        process:(fieldName,file,metadata,load,error,progress,abort,transfer,options)=>{
            @this.upload('imagenmapa',file,load,error,progress)
        },

        revert:(filename,load)=>{
            @this.removeUpload('imagenmapa',filename,load)
        },

    },
});

const labels_es_ES1 = {
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

FilePond.setOptions(labels_es_ES1);

</script>
@endpush
