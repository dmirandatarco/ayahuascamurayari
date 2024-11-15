<div>
    <form id="contact" method="POST" class="forms-sample" enctype="multipart/form-data" wire:submit.prevent="register">
    <div class="row inbox-wrapper">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="mb-3">CREAR ENDOSE INN</h4>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="idPasajero" class="form-label">PASAJERO:</label>
                            <div wire:ignore>
                                <select class="form-control idPasajero" name="idPasajero" id="idPasajero" wire:model="idPasajero">
                                    <option value="" >SELECCIONE</option>
                                    @foreach($pasajeros as $pasajero)
                                        <option value="{{$pasajero->nombre}}">{{$pasajero->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('idPasajero')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label" for="email">EMAIL:</label>
                            <input type="text" class="form-control" placeholder="E-mail" name="email" id="email" wire:model.defer="email">
                            @error('email')
                                <span class="error-message" style="color:red" >{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label" for="celular">CELULAR:</label>
                            <input type="text" class="form-control" placeholder="Celular" name="celular" id="celular" wire:model.defer="celular">
                            @error('celular')
                                <span class="error-message" style="color:red" >{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-3">
                            <div wire:ignore>
                                <label for="pais_id" class="form-label">PAIS / NACIONALIDAD:</label>
                                <select class="form-control pais_id" name="pais_id" id="pais_id" wire:model.defer="pais_id">
                                    <option value="" >SELECCIONE</option>
                                    @foreach($paises as $pais)
                                        <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('pais_id')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <h4 class="mb-4">DETALLES DE TOURS</h4>
                            <div class="col-md-12 mb-3">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1"><label class="form-label"> Nº</label></th>
                                                <th class="col-md-1"><label class="form-label"> FECHA</label></th>
                                                <th class="col-md-2"><label class="form-label"> TOUR</label></th>
                                                <th class="col-md-2"><label class="form-label"> HOTEL</label></th>
                                                <th class="col-md-1"><label class="form-label"> PRECIO</label></th>
                                                <th class="col-md-1"><label class="form-label"> INGRESO</label></th>
                                                <th class="col-md-2"><label class="form-label"> OBSERVACIÓN</label></th>
                                                <th class="col-md-1"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for($i=0;$i<$cont;$i++)
                                            <tr >
                                                <td><input type="number" class="form-control" placeholder="Nº" name="cantidad[]" id="cantidad.{{$i}}" wire:model.defer="cantidad.{{$i}}">
                                                    @error('cantidad.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligaotrio</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" min="{{date("Y-m-d")}}"  name="fecha_viaje[]" id="fecha_viaje.{{$i}}" wire:model.defer="fecha_viaje.{{$i}}">
                                                    @error('fecha_viaje.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligaotrio</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <div wire:ignore>
                                                        <select class="form-control" name="tour_id[]" id="tour_id{{$i}}" wire:model.defer="tour_id.{{$i}}">
                                                            <option value="" >SELECCIONE</option>
                                                            @foreach($tours as $tour)
                                                                <option value="{{$tour->id}}">{{$tour->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('tour_id.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligaotrio</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <div wire:ignore>
                                                        <select class="form-control" name="hotel_id[]" id="hotel_id{{$i}}" wire:model.defer="hotel_id.{{$i}}">
                                                            <option value="" >SELECCIONE</option>
                                                            @foreach($hoteles as $hotel)
                                                                <option value="{{$hotel->nombre}}">{{$hotel->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('hotel_id.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligaotrio</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" name="precio[]" id="precio.{{$i}}" wire:model.lazy="precio.{{$i}}" step="0.01" placeholder="Precio">
                                                    @error('precio.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
                                                    @enderror
                                                </td>
                                                <td><input type="number" class="form-control" placeholder="S/ " name="ingreso[]" id="ingreso.{{$i}}" wire:model.defer="ingreso.{{$i}}">
                                                    @error('ingreso.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="observacion[]" id="observacion.{{$i}}" wire:model.defer="observacion.{{$i}}" placeholder="Descripción"></textarea>
                                                    @error('observacion.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligaotrio</span>
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
                    <div class="row flex justify-content-end">
                        <div class="mb-3 col-md-2">
                            <div wire:ignore>
                                <label for="agencia_id" class="form-label">AGENCIA:</label>
                                <select class="form-select" name="agencia_id" id="agencia_id" wire:model.defer="agencia_id">
                                    <option >SELECCIONE</option>
                                    @foreach($agencias as $agencia)
                                        <option value="{{$agencia->id}}" >{{$agencia->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('agencia_id')
                                <span class="error-message" style="color:red">Campo Obligaotrio</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-2">
                            <div wire:ignore>
                                <label for="moneda_id" class="form-label">MONEDA:</label>
                                <select class="form-select" name="moneda_id" id="moneda_id" wire:model.defer="moneda_id">
                                    <option value="" >SELECCIONE</option>
                                    @foreach($monedas as $moneda)
                                        <option value="{{$moneda->id}}" >{{$moneda->abreviatura}} {{$moneda->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('moneda_id')
                                <span class="error-message" style="color:red">Campo Obligaotrio</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="pago" class="form-label">POR COBRAR:</label>
                            <input type="number" class="form-control" name="pago" id="pago" wire:model.defer="pago">
                            @error('pago')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                        <th><label class="form-label"> COSTO</label></th>
                                        <th><label class="form-label"> OBSERVACIÓN</label></th>
                                        <th>
                                            @if($cont2<1)
                                                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Aumentar" class="btn btn-success btn-icon" wire:click="aumentarServicio">+</button>
                                            @else
                                                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Reducir" class="btn btn-danger btn-icon" wire:click="reducirServicio">-</button>
                                            @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($j=0;$j<$cont2;$j++)
                                    <tr>
                                        <td style="width:100px"><input type="number" class="form-control" placeholder="Nº" name="cantidadsevicio[]" id="cantidadsevicio{{$j}}" wire:model.defer="cantidadsevicio.{{$j}}">
                                            @error('cantidadsevicio.'.$i)
                                                <span class="error-message" style="color:red">Campo Obligaotrio</span>
                                            @enderror
                                        </td>
                                        <td>
                                        <div wire:ignore>
                                            <select class="form-control" name="servicio_id[]" id="servicio_id{{$j}}" wire:model.defer="servicio_id.{{$j}}">
                                                <option value="" >SELECCIONE</option>
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
                                            <input type="number" class="form-control" name="precio_operacion[]" id="precio_operacion{{$j}}" wire:model.lazy="precio_operacion.{{$j}}" step="0.01" placeholder="Precio">
                                            @error('precio_operacion.'.$j)
                                                <span class="error-message" style="color:red">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <textarea class="form-control" name="descripcion[]" id="descripcion.{{$j}}" wire:model.defer="descripcion.{{$j}}" placeholder="Descripción"></textarea>
                                            @error('descripcion.'.$j)
                                                <span class="error-message" style="color:red">{{ $message }}</span>
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
                </div>
            </div>
        </div>
        <div class="row flex justify-content-end mb-4">
            <div class="col-md-1  flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2 ">Guardar</button>
            </div>
        </div>
    </div>
</div>
@push('custom-scripts')
<script>
$('#idPasajero').select2({
    tags: true,
});
$('#idPasajero').on('change',function(){
    @this.set('idPasajero',this.value);
});

$('#agencia_id').select2({
    tags: true,
});
$('#agencia_id').on('change',function(){
    @this.set('agencia_id',this.value);
});

$('#tour_id0').select2();
$('#tour_id0').on('change',function(){
    @this.set('tour_id.0',this.value);
});

$('#hotel_id0').select2({
    tags: true,
});
$('#hotel_id0').on('change',function(){
    @this.set('hotel_id.0',this.value);
});

Livewire.on('aumentarTour', function (id) {
        $('#tour_id'+id).select2();
        $('#tour_id'+id).on('change', function (e) {
            @this.set('tour_id.'+id, this.value);
        });
});

Livewire.on('aumentarHotel', function (id) {
        $('#hotel_id'+id).select2({
            tags: true,
        });
        $('#hotel_id'+id).on('change', function (e) {
            @this.set('hotel_id.'+id, this.value);
        });
});
Livewire.on('aumentarServicios', function (id) {
        $('#servicio_id'+id).select2();
        $('#servicio_id'+id).on('change', function (e) {
            @this.set('servicio_id.'+id, this.value);
        });
});
Livewire.on('sinEncontrar', postId => {
    jQuery(document).ready(function () {
        $('#pais_id').select2();
        $('#pais_id').on('change', function (e) {
            @this.set('pais_id', this.value);
        });
    });
});

Livewire.on('Encontrar', function (id) {
        $('#pais_id').val(id).select2();
        $('#pais_id').on('change', function (e) {
            @this.set('pais_id', this.value);
        });
});
</script>
@endpush
