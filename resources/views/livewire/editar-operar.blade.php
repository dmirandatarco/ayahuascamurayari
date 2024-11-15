<div>
    <form action="{{route('operar.update',$operar)}}" method="post" class="form-horizontal" enctype="multipart/form-data">
        {{method_field('patch')}}
        {{csrf_field()}}
    <div class="row inbox-wrapper">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="mb-3">EDITAR OPERACION</h4>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="idTour" class="form-label">TOURS:</label>
                            <div wire:ignore>
                                <select class="form-control idTour" name="idTour" id="idTour" wire:model="idTour" required disabled>
                                    <option value="" >SELECCIONE</option>
                                    @foreach($tours as $tour)
                                        <option value="{{$tour->id}}">{{$tour->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('idTour')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label" for="email">FECHA DE VIAJE:</label>
                            <input type="date" class="form-control" min="{{date("Y-m-d")}}" readonly name="fechaviaje" id="fechaviaje" wire:model.lazy="fechaviaje" required>
                            @error('fechaviaje')
                                <span class="error-message" style="color:red">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="observacion">OBSERVACION:</label>
                            <input type="text" class="form-control" placeholder="Observacion" name="observacion" id="observacion" wire:model.defer="observacion">
                            @error('observacion')
                                <span class="error-message" style="color:red" >{{ $message }}</span>
                            @enderror
                        </div>
                        @if($servicios)
                            @foreach($servicios as $servicio)
                                <div class="mb-3 col-md-3">
                                    <label for="idServicio" class="form-label">{{$nombreServicio[$servicio->id]}}</label>
                                    <div wire:ignore id="my-div{{$servicio->id}}">
                                        <select class="form-control idTour" name="idServicio[$servicio->id]" id="idServicio{{$servicio->id}}" wire:model="idServicio.{{$servicio->id}}" required>
                                            <option value="" >SELECCIONE</option>
                                            @foreach($proveedors[$servicio->id] as $proveedor)
                                                <option value="{{$proveedor->id}}">{{$proveedor->text}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('idServicio.'.$servicio->id)
                                        <span class="error-message" style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="email">COSTO:</label>
                                    <input type="number" step="0.01" class="form-control" min="1"  name="precioServicio[$servicio->id]" id="precioServicio{{$servicio->id}}" wire:model.defer="precioServicio.{{$servicio->id}}" required>
                                    @error('precioServicio.'.$servicio->id)
                                        <span class="error-message" style="color:red">Campo Obligaotrio</span>
                                    @enderror
                                </div>
                            @endforeach
                        @else
                        @endif
                        <div class="col-md-12">
                            <div class="col-md-12 mb-3">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><label class="form-label"> PAX</label></th>
                                                <th><label class="form-label"> PASAJERO</label></th>
                                                <th><label class="form-label"> CONTRATO</label></th>
                                                <th><label class="form-label"> HOTEL</label></th>
                                                <th><label class="form-label"> INGRESOS</label></th>
                                                <th><label class="form-label"> HORA DE RECOJO</label></th>
                                                <th><label class="form-label"> SALDO</label></th>
                                                <th><label class="form-label"> OBSERVACIONES</label></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="cuerpo">
                                            @foreach ($detalles  ?? [] as $i => $detalle)

                                                <tr>
                                                    <td>
                                                        {{$detalle->detalle->cantidad}}
                                                        <input type="hidden" name="detalle[]" value="{{$detalle->detalle->id}}">
                                                    </td>
                                                    <td>{{$detalle->detalle->reserva->pasajero->nombre}} {{$detalle->detalle->reserva->pasajero->celular}}</td>
                                                    <td>{{$detalle->detalle->reserva->user->nombre}} </td>
                                                    <td>{{$detalle->detalle->hotel->nombre}}</td>
                                                    <td>{{$detalle->detalle->ingreso}}</td>
                                                    <td>
                                                        <input type="time" class="form-control" name="hora[]" required value="{{$detalle->horarecojo}}">
                                                        <span class="text-danger">@error('hora.*'){{$message}}@enderror</span>
                                                    </td>
                                                    <td>
                                                        @foreach($detalle->detalle->reserva->totales as $total)
                                                            @if($loop->last)
                                                                {{$total->moneda->abreviatura}} {{$total->saldo}}
                                                            @else
                                                                {{$total->moneda->abreviatura}} {{$total->saldo}} /
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>{{$detalle->detalle->observacion}}</td>
                                                    <td>
                                                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Eliminar" class="btn btn-danger btn-icon"  wire:click.prevent="remove({{$i}})">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </td>

                                                </tr>
                                            @endforeach
                                            @foreach ($detalles2  ?? [] as $j => $detalle)

                                                <tr>
                                                    <td>
                                                        {{$detalle->cantidad}}
                                                        <input type="hidden" name="detalle2[]" value="{{$detalle->id}}">
                                                    </td>
                                                    <td>{{$detalle->reserva->pasajero->nombre}}</td>
                                                    <td>{{$detalle->reserva->user->nombre}} </td>
                                                    <td>{{$detalle->hotel->nombre}}</td>
                                                    <td>{{$detalle->ingreso}}</td>
                                                    <td>
                                                        <input type="time" class="form-control" name="hora2[]" required>
                                                        <span class="text-danger">@error('hora.*'){{$message}}@enderror</span>
                                                    </td>
                                                    <td>{{$detalle->observacion}}</td>
                                                    <td>
                                                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Eliminar" class="btn btn-danger btn-icon"  wire:click.prevent="remove2({{$j}})">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <td>Cantidad:
                                                <input type="hidden" name="cantidad" id="cantidad" value="{{$cantidadpasajeros}}">
                                            </td>
                                            <td>{{$cantidadpasajeros}}</td>
                                            <td>Monto:
                                                <input type="hidden" name="monto_dar" id="monto_dar" value="{{$monto_dar}}">
                                            </td>
                                            <td>{{$monto_dar}}</td>
                                        </tfoot>
                                    </table>
                                </div>
                            </div><!-- Col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row flex justify-content-end">
        <div class="col-md-1  flex justify-content-end">
            <button type="submit" class="btn btn-primary me-2 " @disabled($cantidadpasajeros == 0)>Guardar</button>
        </div>
    </div>
</div>
@push('custom-scripts')
<script>

var simpleList = document.querySelector("#cuerpo");
new Sortable(simpleList, {
    animation: 150,
    ghostClass: 'bg-light'
});
</script>
@foreach($servicios as $servicio)
<script>
$('#idServicio{{$servicio->id}}').val('{{$idServicio[$servicio->id]}}').select2({
    tags: true,
});
$('#idServicio{{$servicio->id}}').on('change',function(){
    @this.set('idServicio.{{$servicio->id}}',this.value);
});
</script>
@endforeach
@endpush
