<div>
    <form action="{{route('liquidacion.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
        {{csrf_field()}}
    <div class="row inbox-wrapper">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="mb-3">CREAR LIQUIDACION DE EGRESO</h4>
                    <input type="hidden" name="tipo" value="2">
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="idTour" class="form-label">CATEGORIA:</label>
                            <div wire:ignore>
                                <select class="form-control" name="idCategoria" id="idCategoria" wire:model="idCategoria" required>
                                    <option value="" >SELECCIONE</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('idCategoria')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="idTour" class="form-label">PROVEEDOR:</label>
                            <div wire:ignore>
                                <select class="form-control" name="idProveedor" id="idProveedor" wire:model="idProveedor" required>
                                    <option value="" >SELECCIONE</option>
                                </select>
                            </div>
                            @error('idProveedor')
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
                        <div class="mb-3 col-md-3">
                            <label class="form-label" for="observacion">OBSERVACION:</label>
                            <textarea type="text" class="form-control" placeholder="Observacion" name="observacion" id="observacion" wire:model.defer="observacion"></textarea>
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
                                                <th><label class="form-label"> SERVICIO</label></th>
                                                <th><label class="form-label"> PRECIO</label></th>
                                                <th><label class="form-label"> SUB TOTAL</label></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="cuerpo">
                                            @foreach ($detalles  ?? [] as $i => $detalle)
                                                <tr>
                                                    <td>{{date("d-m-Y", strtotime($detalle->operar->fecha))}}</td>
                                                    <td>
                                                        {{$detalle->operar->cantidad}}
                                                        <input type="hidden" name="detalle[]" value="{{$detalle->id}}">
                                                        <input type="hidden" name="cantidad[]" value="{{$detalle->operar->cantidad}}">
                                                    </td>
                                                    <td>{{$detalle->servicio->nombre}} </td>
                                                    <td>{{$detalle->monto}}
                                                        <input type="hidden" name="precio[]" value="{{$detalle->monto}}">
                                                    </td>
                                                    <td>{{number_format($detalle->monto,2)}}</td>
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
                                                <td colspan="5">TOTAL:</td>
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
$('#idCategoria').select2();

$('#idCategoria').on('change',function(){
    @this.set('idCategoria',this.value);
});


Livewire.on('aumentar', function (datos) {
    $('#idProveedor').empty();
    $('#idProveedor').select2({
        data: datos,
    });
    $('#idProveedor').on('change', function (e) {
        @this.set('idProveedor', this.value);
    });
});

</script>
@endpush
