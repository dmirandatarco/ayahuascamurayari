<div>
    <form id="contact" method="POST" class="forms-sample" enctype="multipart/form-data" wire:submit.prevent="register">
        <div class="row inbox-wrapper">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="mb-3">CREAR PAQUETE</h4>
                        <div class="row">
                            <div class="mb-3 col-md-8">
                                <label class="form-label" for="nombre">TITULO PRINCIPAL:</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Titulo principal" id="nombre" wire:model.defer="nombre" required>
                                @error('nombre')
                                <span class="error-message" style="color:red">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label" for="cantidad">PAX:</label>
                                <input type="text" class="form-control" name="cantidad" placeholder="cant. pasajeros" id="cantidad" wire:model.lazy="cantidad" required>
                                @error('cantidad')
                                <span class="error-message" style="color:red">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label" for="dia">DIAS:</label>
                                <input type="text" class="form-control" name="dia" id="dia" placeholder="cantidad de dias" wire:model.defer="dia" required>
                                @error('dia')
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
                                                    <th class="col-md-2"><label class="form-label"> PRECIO</label></th>
                                                    <th class="col-md-3"><label class="form-label"> OBSERVACIÓN</label></th>
                                                    <th class="col-md-1"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for($i=0;$i<$cont;$i++) <tr>
                                                    <td>
                                                        <div wire:ignore>
                                                            <select class="form-control" name="tour_id[]" id="tour_id{{$i}}" wire:model.lazy="tour_id.{{$i}}">
                                                                <option value="">SELECCIONE</option>
                                                                @foreach($tours as $tour)
                                                                <option value="{{$tour->id}}">{{$tour->nombre}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('tour_id.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
                                                        @enderror
                                                    </td>
                                                    <td><input type="date" class="form-control" placeholder="dia " name="dia_tour[]" id="dia_tour.{{$i}}" wire:model.defer="dia_tour.{{$i}}">
                                                        @error('dia_tour.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
                                                        @enderror
                                                    </td>
                                                    <td><input type="number" class="form-control" placeholder="precio " name="precio[]" id="precio.{{$i}}" wire:model.lazy="precio.{{$i}}">
                                                        @error('precio.'.$i)
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
                                                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Reducir" class="btn btn-danger btn-icon" wire:click="reducir">-</button>
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
                                            <th><label class="form-label"> PRECIO</label></th>
                                            <th>
                                                @if($cont2<1) <button type="button"  data-bs-toggle="tooltip" data-bs-title="Aumentar" class="btn btn-success btn-icon" wire:click="aumentarServicio">+</button>
                                                    @else
                                                    <button type="button"  data-bs-toggle="tooltip" data-bs-title="Reducir" class="btn btn-danger btn-icon" wire:click="reducirServicio">-</button>
                                                    @endif
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for($j=0;$j<$cont2;$j++) <tr>
                                            <td style="width:100px"><input type="number" class="form-control" placeholder="Nº" name="cantidadservicio[]" id="cantidadservicio{{$j}}" wire:model.lazy="cantidadservicio.{{$j}}">
                                                @error('cantidadservicio.'.$i)
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
                                            <td style="width:100px"><input type="number" class="form-control" placeholder="Nº" name="precioservicio[]" id="precioservicio{{$j}}" wire:model.lazy="precioservicio.{{$j}}">
                                                @error('precioservicio.'.$i)
                                                <span class="error-message" style="color:red">Campo Obligatorio</span>
                                                @enderror
                                            </td>
                                            <td>
                                                @if($j==$cont2-1)
                                                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Aumentar" class="btn btn-success btn-icon" wire:click="aumentarServicio">+</button>
                                                @else
                                                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Reducir" class="btn btn-danger btn-icon" wire:click="reducirServicio">-</button>
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
                                <input type="number" class="form-control" name="total" id="total" wire:model="total" readonly>
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
    $('#tour_id0').select2({
        width: '100%',
    });
    $('#tour_id0').on('change', function() {
        @this.set('tour_id.0', this.value);
    });
    Livewire.on('aumentarTour', function(id) {
        $('#tour_id' + id).select2({
            width: '100%',
        });
        $('#tour_id' + id).on('change', function(e) {
            @this.set('tour_id.' + id, this.value);
        });
    });
    Livewire.on('aumentarServicios', function(id) {
        $('#servicio_id' + id).select2({
            width: '100%',
        });
        $('#servicio_id' + id).on('change', function(e) {
            @this.set('servicio_id.' + id, this.value);
        });
    });

</script>
@endpush
