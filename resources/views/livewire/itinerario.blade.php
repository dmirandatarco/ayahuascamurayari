<div class="card">
    <div class="card-body">
        <label class="h4 mb-3" for="imagenes">Itinerario:</label><br>
        <button type="button" class="btn btn-success me-2" wire:click="aumentar"><i class="fa fa-plus"></i> &nbsp;Añadir</button>
        <button type="button" class="btn btn-danger me-2" wire:click="reducir"><i class="fa fa-times"></i> &nbsp;Reducir</button>
        <div class="container-fluid mt-5 justify-content-center w-100">
            <div class="accordion" id="acordionProcesos">
                @for($i=0; $i < $cont; $i++)
            
                <div class="accordion-item" wire:ignore>
                    <h2 class="accordion-header" id="titulo-{{$i}}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">
                            Sección {{$i+1}}
                        </button>
                    </h2>
                    <div id="collapse{{$i}}" class="accordion-collapse collapse" aria-labelledby="titulo-{{$i}}" data-bs-parent="#acordionProcesos">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="titulo">Titulo:</label>
                                    <input type="text" class="form-control" name="titulo[]" wire:model.defer="titulo.{{$i}}">
                                    <label class="form-label" for="descipcionItineario">Descripcion:</label>
                                    <textarea class="form-control" name="descipcionItineario[]" id="descipcionItineario{{$i}}" rows="10" wire:model.defer="descipcionItineario.{{$i}}"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>    
        </div>
    </div>
</div>


@push('custom-scripts')
@for($i=0;$i<$contTotal;$i++)
<script>
    ClassicEditor
    .create( document.querySelector( '#descipcionItineario'+{{$i}} ), {
        language: 'es',
    })
    .then(editor => {
        // Aquí asignas el valor inicial al editor después de eliminar las etiquetas HTML y decodificar las entidades HTML
        const decodedValue = document.createElement('textarea');
        decodedValue.innerHTML = '{{$descipcionItineario[$i]}}';
        const plainTextValue = decodedValue.value;
        editor.setData(plainTextValue);

        editor.model.document.on('change:data', () => {
            // Puedes añadir lógica adicional aquí si es necesario
        });

        editor.keystrokes.set( 'space', ( key, stop ) => {
            editor.execute( 'input', { text: '\u00a0' } );
            stop();
        });
    })
    .catch(error => {
        console.error(error);
    });
</script>
@endfor
<script>
Livewire.on('Aumentar', function (id) {
    ClassicEditor
    .create( document.querySelector( '#descipcionItineario'+id ),{
    language: 'es',
    })
    
    .then(editor => {
        editor.model.document.on('change:data', () => {
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

@endpush