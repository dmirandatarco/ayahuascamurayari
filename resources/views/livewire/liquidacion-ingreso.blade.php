<div>
    <form action="{{route('liquidacion.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
        {{csrf_field()}}
    <div class="row inbox-wrapper">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="mb-3">CREAR LIQUIDACION DE INGRESO</h4>
                    <input type="hidden" name="tipo" value="1">
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="idTour" class="form-label">AGENCIA:</label>
                            <div wire:ignore>
                                <select class="form-control" name="idAgencia" id="idAgencia" wire:model="idAgencia" required>
                                    <option value="" >SELECCIONE</option>
                                    @foreach($agencias as $agencia)
                                        <option value="{{$agencia->id}}">{{$agencia->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('idAgencia')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label" for="email">HASTA:</label>
                            <input type="date" class="form-control"  name="fecha" id="fecha" wire:model.lazy="fecha" required>
                            @error('fecha')
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
                        <div class="col-md-12">
                            <div class="col-md-12 mb-3">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><label class="form-label"> FECHA</label></th>
                                                <th><label class="form-label"> PAX</label></th>
                                                <th><label class="form-label"> PASAJERO</label></th>
                                                <th><label class="form-label"> TOUR</label></th>
                                                <th><label class="form-label"> PRECIO</label></th>
                                                <th><label class="form-label"> COBRAR</label></th>
                                                <th><label class="form-label"> SUB TOTAL</label></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="cuerpo">
                                            @foreach ($detalles  ?? [] as $i => $detalle)
                                                <tr>
                                                    <td>{{date("d-m-Y", strtotime($detalle->fecha_viaje))}}</td>
                                                    <td>
                                                        {{$detalle->cantidad}}
                                                        <input type="hidden" name="detalle[]" value="{{$detalle->id}}">
                                                        <input type="hidden" name="cantidad[]" value="{{$detalle->cantidad}}">
                                                    </td>
                                                    <td>{{$detalle->reserva->pasajero->nombre}} {{$detalle->reserva->pasajero->celular}}</td>
                                                    <td>{{$detalle->tour->nombre}} </td>
                                                    <td>{{$detalle->precio}}
                                                        <input type="hidden" name="precio[]" value="{{$detalle->precio}}">
                                                    </td>
                                                    <td>{{$detalle->reserva->totales[0]->moneda->abreviatura}} {{$detalle->reserva->totales[0]->saldo}}</td>
                                                    <td>{{number_format($detalle->precio*$detalle->cantidad,2)}}</td>
                                                    <td>
                                                        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Eliminar" class="btn btn-danger btn-icon"  wire:click.prevent="remove({{$i}})">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">CANT. SHOW {{$cantidadshow}}  -  CANT. NO SHOW {{$cantidadnoshow}}</td>
                                                <td colspan="3">A CTA. S/ {{$totalagenciasoles}}  -  A CTA. $ {{$totalagenciadolares}}
                                                    <input type="hidden" name="acuenta" value="{{$totalagenciasoles}}">
                                                    <input type="hidden" name="acuentadolares" value="{{$totalagenciadolares}}">
                                                </td>
                                                <td>TOTAL:</td>
                                                <td>{{number_format($totalliquidacion,2)}}
                                                    <input type="hidden" name="monto" value="{{$totalliquidacion}}">
                                                </td>
                                            </tr>
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
            <button type="submit" class="btn btn-primary me-2 " @disabled($totalliquidacion == 0)>Guardar</button>
        </div>
    </div>
</div>
@push('custom-scripts')
<script>
$('#idAgencia').select2({
    tags: true,
});

$('#idAgencia').on('change',function(){
    @this.set('idAgencia',this.value);
});


</script>
@endpush
