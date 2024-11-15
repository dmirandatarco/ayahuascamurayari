<div>
    <form id="contact" method="POST" class="forms-sample" enctype="multipart/form-data" wire:submit.prevent="register">
    <div class="row inbox-wrapper">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="mb-3">AUMENTAR PASAJEROS A LA RESERVA Nº {{$reserva->id}}</h4>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                        </div>
                    @endif
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
                        <div class="mb-3 col-md-2">
                            <label class="form-label" for="email">EMAIL:</label>
                            <input type="text" class="form-control" placeholder="E-mail" name="email" id="email" wire:model.defer="email">
                            @error('email')
                                <span class="error-message" style="color:red" >{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-2">
                            <label class="form-label" for="celular">CELULAR:</label>
                            <input type="text" class="form-control" placeholder="Celular" name="celular" id="celular" wire:model.defer="celular">
                            @error('celular')
                                <span class="error-message" style="color:red" >{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-1">
                            <label class="form-label" for="tipo_documento">DOC.:</label>
                            <select class="form-select" wire:model.defer="tipo_documento" id="tipo_documento" data-live-search="true" >
                                <option value="" >SELECCIONE</option>
                                <option value="DNI" @selected(old('DNI')=="DNI")>DNI</option>
                                <option value="PASAPORTE" @selected(old('PASAPORTE')=="PASAPORTE")>PASAPORTE</option>
                                <option value="CARNET" @selected(old('CARNET')=="CARNET")>CARNET</option>
                                <option value="RUC" @selected(old('RUC')=="RUC")>RUC</option>
                            </select>
                            @error('tipo_documento')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-2">
                            <label class="form-label" for="num_documento">NUMERO:</label>
                            <input type="text" class="form-control" placeholder="Numero de Documento" id="num_documento" name="num_documento" wire:model.defer="num_documento">
                            @error('num_documento')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-2">
                            <div wire:ignore>
                                <label for="pais_id" class="form-label">PAIS / NACIONALIDAD:</label>
                                <select class="form-select pais_id" name="pais_id" id="pais_id" wire:model.defer="pais_id">
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
                            <h4 class="mb-4">PASAJEROS ADICIONALES</h4>
                            <div class="col-md-12 mb-5">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><label class="form-label"> NOMBRE Y APELLIDOS</label></th>
                                                <th><label class="form-label"> EMAIL</label></th>
                                                <th><label class="form-label"> CELULAR</label></th>
                                                <th><label class="form-label"> DOCUMENTO</label></th>
                                                <th><label class="form-label"> NUMERO</label></th>
                                                <th><label class="form-label"> PAIS / NACIONALIDAD</label></th>
                                                <th>
                                                    @if($cont<1)
                                                        <button type="button" data-bs-toggle="tooltip" data-bs-title="Aumentar" class="btn btn-success btn-icon" wire:click="aumentar">+</button>
                                                    @else
                                                        <button type="button" data-bs-toggle="tooltip" data-bs-title="Reducir" class="btn btn-danger btn-icon" wire:click="reducir">-</button>
                                                    @endif
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for($i=0;$i<$cont;$i++)
                                            <tr >
                                                <td>
                                                    <div wire:ignore>
                                                        <select class="form-control" name="idPasajero2" id="idPasajero2{{$i}}" wire:model="idPasajero2.{{$i}}">
                                                            <option value="" disabled>SELECCIONE</option>
                                                            @foreach($pasajeros as $pasajero)
                                                                <option value="{{$pasajero->nombre}}">{{$pasajero->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('idPasajero2.'.$i)
                                                        <span class="error-message" style="color:red">{{ $message }}</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="E-mail" name="email2" id="email2{{$i}}" wire:model.defer="email2.{{$i}}">
                                                    @error('email2.'.$i)
                                                        <span class="error-message" style="color:red" >{{ $message }}</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Celular" name="celular2" id="celular2{{$i}}" wire:model.defer="celular2.{{$i}}">
                                                    @error('celular2.'.$i)
                                                        <span class="error-message" style="color:red" >{{ $message }}</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <div wire:ignore>
                                                        <select class="form-select" wire:model.defer="tipo_documento2.{{$i}}" id="tipo_documento2{{$i}}" data-live-search="true" >
                                                            <option >SELECCIONE</option>
                                                            <option value="DNI" @selected(old('DNI')=="DNI")>DNI</option>
                                                            <option value="PASAPORTE" @selected(old('PASAPORTE')=="PASAPORTE")>PASAPORTE</option>
                                                            <option value="CARNET" @selected(old('CARNET')=="CARNET")>CARNET</option>
                                                            <option value="RUC" @selected(old('RUC')=="RUC")>RUC</option>
                                                        </select>
                                                    </div>
                                                    @error('tipo_documento2.'.$i)
                                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Numero de Documento" id="num_documento2{{$i}}" name="num_documento2" wire:model.defer="num_documento2.{{$i}}">
                                                    @error('num_documento2.'.$i)
                                                        <span class="error-message" style="color:red">{{ $message }}</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <div wire:ignore>
                                                        <select class="form-control pais_id" name="pais_id2" id="pais_id2{{$i}}" wire:model.defer="pais_id2.{{$i}}">
                                                            <option value="" >SELECCIONE</option>
                                                            @foreach($paises as $pais)
                                                                <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('pais_id2.'.$i)
                                                        <span class="error-message" style="color:red">{{ $message }}</span>
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
                            <div class="row flex justify-content-end">
                                <div class="col-md-1  flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-2 ">Guardar</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row inbox-wrapper">
        <form id="contact" method="POST" class="forms-sample" enctype="multipart/form-data" wire:submit.prevent="registerpdf">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="mb-3">PDF DE DOCUMENTOS DE IDENTIDAD</h4>
                    <div class="row">
                        <div class="col-md-9 mb-3">
                            <label class="form-label" for="rutapdf">ARCHIVO DOCUMENTO: </label>
                            <input type="file"  accept="application/pdf" class="form-control" name="rutapdf" id="rutapdf"  wire:model.defer="rutapdf" />
                            <span class="text-danger">@error('rutapdf'){{$message}}@enderror</span>
                        </div><!-- Col -->
                        @if($reserva->pdf!="")
                        <div class="col-md-3 mb-3 mt-4">
                            <a href="{{asset('storage/img/pdf/'.$reserva->pdf->rutapdf)}}" target="_blank">
                                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Ver Documento" class="btn btn-warning " >
                                    Ver Documento
                                </button>
                            </a>
                        </div><!-- Col -->
                        @endif
                    </div>
                </div>
                <div class="row flex justify-content-end mb-5">
                    <div class="col-md-1  flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2 ">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@push('custom-scripts')
@for($i=0;$i<$cont;$i++)
<script>
    $('#idPasajero2{{$i}}').val('{{$idPasajero2[$i]}}').select2({
        tags: true,
    });
    $('#idPasajero2{{$i}}').on('change',function(){
        @this.set('idPasajero2.{{$i}}',this.value);
    });

    $('#pais_id2{{$i}}').val('{{$pais_id2[$i]}}').select2();
    $('#pais_id2{{$i}}').on('change', function (e) {
        @this.set('pais_id2.'+id, this.value);
    });
</script>
@endfor
<script>
$('#idPasajero').val('{{$idPasajero}}').select2({
    tags: true,
});
$('#idPasajero').on('change',function(){
    @this.set('idPasajero',this.value);
});

Livewire.on('aumentarPasajero', function (id) {
    $('#idPasajero2'+id).select2({
        tags: true,
    });
    $('#idPasajero2'+id).on('change', function (e) {
        @this.set('idPasajero2.'+id, this.value);
    });
    $('#pais_id2'+id).select2();
    $('#pais_id2'+id).on('change', function (e) {
        @this.set('pais_id2.'+id, this.value);
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
