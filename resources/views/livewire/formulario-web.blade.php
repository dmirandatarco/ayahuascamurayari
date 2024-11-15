<div class="col-lg-4 col-md-12 col-sm-12 right_Details">
    <div class="p-4 shadow ml-lg-4 rounded sticky-top" style="top: 100px;">
        <h2 class="text-uppercase text-primary text-center h1">
        {{ __('Reserva')}}
        </h2>
        <h2 class="text-muted text-center">
            {{$model->nombre}}
        </h2>
        <p class="text-muted text-center"><span class="text-danger h2">${{number_format($total,2)}}</span> x pax</p>
        <hr class="my-2">
        <div class="form-group" >
            <label for="bookingDate" class="form-label">{{ __('Seleccione')}} {{ __('Fecha')}}</label>
            <div id="dayReservation" style="position: relative;" wire:ignore>
            </div>
        </div>
        <div class="form-group mb-4">
            <label for="guests" class="form-label mb-2">{{ __('Cantidad')}} {{ __('Pasajeros')}}</label>
            <br>
            <span class="h5 ml-3  mr-3">
                PAX
            </span>
            <button class="btn btn-danger  border-radius-100 mr-3" wire:click="disminuir()">
                <span class="m-1">-</span>
            </button>
            <span class="text-uppercase h2 mr-3">
                {{$cantidad}}
            </span>
            <button class="btn btn-danger  border-radius-100 mr-3" wire:click="aumentar()">
                <span class="m-1">+</span>
            </button>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block" @disabled($total==0)
            wire:click="addItem"
            wire:loading.attr="disabled"
            wire:target="addItem">{{ __('AGREGAR AL CARRITO')}}</button>
        </div>
        @if ($message = Session::get('success'))
            <span class="error-message" style="color:red">{{ $message }}</span>
        @endif
    </div>
    
    <div wire:ignore.self class="modal fade bd-example-modal-lg" id="Agregar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="spanTexto" >Crear Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-scripts')
<script >

    Livewire.on('close-modal', function (id) {
        $('#Agregar').modal('hide');
        $('#clienteId').val(id).select2();
        $('#clienteId').on('change', function (e) {
            @this.set('clienteId', this.value);
        });
    });

    function agregar(){
        $('#Agregar').modal('show');
    }

    $('#dayReservation').datepicker({
        dateFormat: "yy-mm-dd",
        minDate: 0, // Bloquear fechas anteriores a hoy
        onSelect: function(fecha) {
            @this.set('fecha', fecha);
        }
    });
</script>
@endpush
