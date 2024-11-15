<div>
    <div wire:ignore>
        <input type="file" name="imagenes[]" id="imagenes" class="form-control" wire:model='imagenes' multiple>
        @error('imagenes')
            <span class="error-message" style="color:red">{{ $message }}</span>
        @enderror
    </div>
    @if($imagenes)
        @foreach($imagenes as $imagen)
            <img src="{{$imagen->temporaryURL()}}"  class="imagen-principal mr-2">
        @endforeach
    @endif
</div>
@push('custom-scripts')
<script>

// Get a reference to the file input element
const inputElement2 = document.querySelector('#imagenes');


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
            @this.upload('imagenes',file,load,error,progress)
        },

        revert:(filename,load)=>{
            @this.removeUpload('imagenes',filename,load)
        },

    },
});



</script>
@endpush
