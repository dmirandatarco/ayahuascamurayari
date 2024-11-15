<div>
    <div wire:ignore>
        <input type="file" name="imagenes[]" accept="image/*" id="imagenes" class="form-control" wire:model='imagenes' multiple>
        @error('imagenes')
            <span class="error-message" style="color:red">{{ $message }}</span>
        @enderror
    </div>
    @if($imagenesanteriores)
        @foreach($imagenesanteriores as $i => $image)
            <button class="badge btn-danger position-absolute mt-2 ms-2" wire:click.prevent="eliminarfotos({{$i}})">X</button>
            <img src="{{asset('storage/img/nosotros/'.$image->nombre)}}"  class="imagen-principal">
        @endforeach
    @endif
    <input type="hidden" name="imagenes2" id="imagenes2" class="form-control" value='{{$imagenesanteriores}}'>
    @if($imagenes)
        @foreach($imagenes as $imag)
            <img src="{{$imag->temporaryURL()}}"  class="imagen-principal mr-2">
        @endforeach
    @endif
</div>


@push('custom-scripts')
<script>

// Get a reference to the file input element
const inputElement2 = document.querySelector('#imagenes');


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
            @this.upload('galeria',file,load,error,progress)
        },

        revert:(filename,load)=>{
            @this.removeUpload('galeria',filename,load)
        },

    },
});



</script>
@endpush
