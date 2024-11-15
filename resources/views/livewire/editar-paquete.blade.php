<div>
    <form id="contact" method="POST" class="forms-sample" enctype="multipart/form-data" wire:submit.prevent="register">
        <div class="row inbox-wrapper">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="mb-3">EDITAR PAQUETE</h4>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="nombre">TITULO PRINCIPAL:</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Titulo principal" id="nombre" wire:model.defer="nombre" required>
                                @error('nombre')
                                <span class="error-message" style="color:red">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="titulo2">SUBTITULO:</label>
                                <input type="text" class="form-control" name="titulo2" placeholder="Subtitulo" id="titulo2" wire:model.defer="titulo2" required>
                                @error('titulo2')
                                <span class="error-message" style="color:red">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label" for="cantidad">PAX:</label>
                                <input type="text" class="form-control" name="cantidad" placeholder="cant. pasajeros" id="cantidad" wire:model.defer="cantidad" required>
                                @error('cantidad')
                                <span class="error-message" style="color:red">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label" for="dia">DIAS:</label>
                                <input type="text" class="form-control" name="dia" id="dia" placeholder="cantidad de dias" wire:model.defer="dia" required>
                                @error('dia')
                                <span class="error-message" style="color:red">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label" for="altura">ALTURA:</label>
                                <input type="text" class="form-control" name="altura" id="altura" placeholder="max. altitud" wire:model.defer="altura" required>
                                @error('altura')
                                <span class="error-message" style="color:red">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3" >
                            </div>
                            <!--
                            <div class="mb-3 col-md-12">
                                <label class="form-label" for="imgprincipal">Imagen Principal:</label>
                                <input type="file" name="imgprincipal" accept="image/*" id="imgprincipal" class="form-control" wire:model='imgprincipal'>
                                @error('imgprincipal')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div> -->

                            <div class="d-md-block col-md-12 col-xl-12">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="w-100" wire:ignore>
                                            <label class="form-label" for="imgprincipal">Imagen Principal:</label>
                                            <input type="file" name="imgprincipal" id="imgprincipal" class="form-control" wire:model='imagen'>
                                            @error('imgprincipal')
                                                <span class="error-message" style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>


                                            @if($imgprincipal!= null)
                                            <img src="{{asset('storage/img/paquetes/'.$imgprincipal)}}"  class="imagen-principal img-thumbnail w-25">
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-md-block col-md-12 col-xl-12">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="w-100" wire:ignore>
                                            <label class="form-label" for="mapa">Mapa:</label>
                                            <input type="file" name="mapa" id="mapa" class="form-control" wire:model='imagen2'>
                                            @error('mapa')
                                                <span class="error-message" style="color:red">{{ $message }}</span>
                                            @enderror
                                        </div>

                                            @if($mapa!= null)
                                            <img src="{{asset('storage/img/paquetes/'.$mapa)}}"  class="imagen-principal img-thumbnail w-25">
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <!--
                            <div class="mb-3 col-md-12">
                                <label class="form-label" for="mapa">Imagen Mapa:</label>
                                <input type="file" name="mapa" accept="image/*" id="mapa" class="form-control" wire:model='mapa'>
                                @error('mapa')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div> -->
                            <!-- <div class="mb-3 col-md-6" wire:ignore>
                                {{ $descripcion }}
                                <label class="form-label" for="descripcion">Descripción:</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" rows="10" wire:model.defer='descripcion'>{{old('descripcion')}}</textarea>
                                @error('descripcion')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div> -->

                            <div class="d-md-block col-md-12 col-xl-6">
                                <div class="card-body"wire:ignore>
                                    <label class="form-label" for="descripcion">Descripción:</label>
                                    <textarea class="form-control" name="descripcion" id="descripcion" rows="10" wire:model="descripcion"></textarea>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6" wire:ignore>
                                <label class="form-label" for="recomendaciones">Recomendaciones:</label>
                                <textarea class="form-control" name="recomendaciones" id="recomendaciones" rows="10" wire:model.defer='recomendaciones'>{{old('recomendaciones')}}</textarea>
                                @error('recomendaciones')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6" wire:ignore>
                                <label class="form-label" for="incluye">Incluye:</label>
                                <textarea class="form-control" name="incluye" id="incluye" rows="10" wire:model.defer='incluye'>{{old('incluye')}}</textarea>
                                @error('incluye')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6" wire:ignore>
                                <label class="form-label" for="noincluye">No Incluye:</label>
                                <textarea class="form-control" name="noincluye" id="noincluye" rows="10" wire:model.defer='noincluye'>{{old('noincluye')}}</textarea>
                                @error('noincluye')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-12">
                                <label class="form-label" for="video">Video YT:</label>
                                <input type="text" class="form-control" name="video" placeholder="Video de Youtube" id="video" wire:model.defer="video" required>
                                @error('video')
                                <span class="error-message" style="color:red">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <h4 class="mb-4">DETALLES DE PAQUETE</h4>
                                <div class="col-md-12 mb-3">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-2"><label class="form-label"> TOUR</label></th>
                                                    <th class="col-md-2"><label class="form-label"> DIA</label></th>
                                                    <th class="col-md-3"><label class="form-label"> OBSERVACIÓN</label></th>
                                                    <th class="col-md-1"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for($i=0;$i<$cont;$i++)
                                                <tr>

                                                    <td>
                                                        <div wire:ignore>
                                                            <select class="form-control" name="tour_id[]" id="tour_id{{$i}}" wire:model.defer="tour_id.{{$i}}">
                                                                <option value="">SELECCIONE</option>
                                                                @foreach($tours as $tour)
                                                                {{--
                                                                    <option value="{{$tour->id}}" @selected(old('tour_id[$i]',$tour->traduccion($lang)?->id)==$tour->id)>{{$tour->nombre}}</option>
                                                                    --}}
                                                                    <option value="{{$tour->id}}">{{$tour->nombre}}</option>

                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('tour_id.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
                                                        @enderror
                                                    </td>
                                                    <td><input type="number" class="form-control" placeholder="dia " name="dia_tour[]" id="dia_tour.{{$i}}" wire:model.defer="dia_tour.{{$i}}">
                                                        @error('dia_tour.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="observacion[]" id="observacion.{{$i}}" wire:model.defer="observacion.{{$i}}" placeholder="Descripción"></textarea>
                                                        @error('observacion.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        @if($i==$cont-1)
                                                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Aumentar" class="btn btn-success btn-icon" wire:click="aumentar">+</button>
                                                        @else
                                                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Reducir" class="btn btn-danger btn-icon" wire:click="reducir({{$i}})">-</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                    @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- Col -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row inbox-wrapper">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="mb-3">SERVICIOS</h4>
                        <div class="col-md-12 mb-3">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><label class="form-label"> CANT.</label></th>
                                            <th><label class="form-label"> SERVICIO</label></th>
                                            <th>
                                            {{--  @if($cont2<1) <button type="button"  data-bs-toggle="tooltip" data-bs-title="Aumentar" class="btn btn-success btn-icon" wire:click="aumentarServicio">+</button>
                                                    @else
                                                    <button type="button"  data-bs-toggle="tooltip" data-bs-title="Reducir" class="btn btn-danger btn-icon" wire:click="reducirServicio({{$j}})">-</button>
                                                    @endif
                                                    --}}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @for($j=0;$j<$cont2;$j++)
                                        <tr>
                                            <td style="width:100px"><input type="number" class="form-control" placeholder="Nº" name="cantidadsevicio[]" id="cantidadsevicio{{$j}}" wire:model.defer="cantidadsevicio.{{$j}}">
                                                @error('cantidadsevicio.'.$i)
                                                <span class="error-message" style="color:red">Campo Obligatorio</span>
                                                @enderror
                                            </td>
                                            <td>
                                                <div wire:ignore>
                                                    <select class="form-control" name="servicio_id[]" id="servicio_id{{$j}}" wire:model.defer="servicio_id.{{$j}}">
                                                        <option value="">SELECCIONE</option>
                                                        @foreach($servicios as $servicio)
                                                        <option value="{{$servicio->id}}">{{$servicio->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('servicio_id.'.$j)
                                                <span class="error-message" style="color:red">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td>
                                                @if($j==$cont2-1)
                                                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Aumentar" class="btn btn-success btn-icon" wire:click="aumentarServicio">+</button>
                                                @else
                                                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Reducir" class="btn btn-danger btn-icon" wire:click="reducirServicio({{$j}})">-</button>
                                                @endif
                                            </td>
                                        </tr>
                                            @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- Col -->
                        <div class="row flex justify-content-end">
                            <div class="mb-3 col-md-2">
                                <div wire:ignore>
                                    <label for="moneda_id" class="form-label">MONEDA:</label>
                                    <select class="form-select" name="moneda_id" id="moneda_id" wire:model.defer="moneda_id">
                                        <option value="">SELECCIONE</option>
                                        @foreach($monedas as $moneda)
                                        <option value="{{$moneda->id}}">{{$moneda->abreviatura}} {{$moneda->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('moneda_id')
                                <span class="error-message" style="color:red">Campo Obligaotrio</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="total" class="form-label">TOTAL:</label>
                                <input type="number" class="form-control" name="total" id="total" wire:model="total">
                                @error('total')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row flex justify-content-end">
            <div class="col-md-1  flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2" @disabled(!($total>0))>Guardar</button>
            </div>
        </div>
</div>
@push('plugin-scripts')

<script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/plugins/ckeditor/es.js') }}"></script>


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
document.addEventListener('livewire:load', function () {
    ClassicEditor
    .create( document.querySelector( '#noincluye' ),{
    language: 'es',
    })
    .then(editor => {
        editor.model.document.on('change:data', () => {
        @this.set('noincluye', editor.getData());
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
document.addEventListener('livewire:load', function () {
    ClassicEditor
    .create( document.querySelector( '#recomendaciones' ),{
    language: 'es',
    })
    .then(editor => {
        editor.model.document.on('change:data', () => {
        @this.set('recomendaciones', editor.getData());
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
document.addEventListener('livewire:load', function () {
    ClassicEditor
    .create( document.querySelector( '#incluye' ),{
    language: 'es',
    })
    .then(editor => {
        editor.model.document.on('change:data', () => {
        @this.set('incluye', editor.getData());
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

@for($i=0;$i<$cont;$i++)
<script>
    $('#tour_id{{$i}}').val('{{$tour_id[$i]}}').select2({
        width: '100%',
    });



    $('#tour_id{{$i}}').on('change',function(){
        @this.set('tour_id.{{$i}}',this.value);
    });

</script>

<script>
    Livewire.on('aumentarTour', function (id) {
        $('#tour_id'+id).select2();
        $('#tour_id'+id).on('change', function (e) {
            @this.set('tour_id.'+id, this.value);
        });
});
</script>
@endfor

@endpush



