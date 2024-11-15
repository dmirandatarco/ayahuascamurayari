<div>
    <form id="contact" method="POST" class="forms-sample" enctype="multipart/form-data" wire:submit.prevent="register">
    <div class="row inbox-wrapper">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="mb-3">CREAR RESERVA</h4>
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
                            @if($tipoReserva == 1)
                            <div class="col-md-12 mb-3">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1"><label class="form-label"> Nº</label></th>
                                                <th class="col-md-1"><label class="form-label"> FECHA</label></th>
                                                <th class="col-md-2"><label class="form-label"> TOUR</label></th>
                                                <th class="col-md-2"><label class="form-label"> HOTEL</label></th>
                                                <th class="col-md-1"><label class="form-label"> MONEDA</label></th>
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
                                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="date" min="{{date("Y-m-d")}}" class="form-control" name="fecha_viaje[]" id="fecha_viaje.{{$i}}" wire:model.defer="fecha_viaje.{{$i}}">
                                                    @error('fecha_viaje.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <div wire:ignore>
                                                        <select class="form-select" name="tour_id[]" id="tour_id{{$i}}" wire:model.defer="tour_id.{{$i}}">
                                                            <option value="" >SELECCIONE</option>
                                                            @foreach($tours as $tour)
                                                                <option value="{{$tour->id}}">{{$tour->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('tour_id.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
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
                                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <select class="form-select" name="moneda_id[]" id="moneda_id.{{$i}}" wire:model.defer="moneda_id.{{$i}}">
                                                        @foreach($monedas as $moneda)
                                                            <option value="{{$moneda->id}}" >{{$moneda->abreviatura}} {{$moneda->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('moneda_id.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
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
                            @else
                            <div class="col-md-12 mb-3">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1"><label class="form-label"> Nº</label></th>
                                                <th class="col-md-2"><label class="form-label"> FECHA</label></th>
                                                <th class="col-md-2"><label class="form-label"> TOUR</label></th>
                                                <th class="col-md-2"><label class="form-label"> HOTEL</label></th>
                                                <th class="col-md-1"><label class="form-label"> INGRESO</label></th>
                                                <th class="col-md-3"><label class="form-label"> OBSERVACIÓN</label></th>
                                                <th class="col-md-1"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for($i=0;$i<$cont;$i++)
                                            <tr >
                                                <td><input type="number" class="form-control" placeholder="Nº" name="cantidad[]" id="cantidad.{{$i}}" wire:model.defer="cantidad.{{$i}}">
                                                    @error('cantidad.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="date" min="{{date("Y-m-d")}}" class="form-control" name="fecha_viaje[]" id="fecha_viaje.{{$i}}" wire:model.defer="fecha_viaje.{{$i}}">
                                                    @error('fecha_viaje.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <div wire:ignore>
                                                        <select class="form-select" name="tour_id[]" id="tour_id{{$i}}" wire:model.defer="tour_id.{{$i}}">
                                                            <option value="" >SELECCIONE</option>
                                                            @foreach($tours as $tour)
                                                                <option value="{{$tour->id}}">{{$tour->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('tour_id.'.$i)
                                                        <span class="error-message" style="color:red">Campo Obligatorio</span>
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
                            @endif
                        </div>
                    </div>
                    @if($tipoReserva==1 && $totalsoles > 0 || $totaldolares > 0 && $tipoReserva==1)
                    <div class="row flex justify-content-end">
                        {{-- <div class="mb-3 col-md-2">
                            <label for="acuentasoles" class="form-label">A CUENTA S/:</label>
                            <input type="number" class="form-control" name="acuentasoles" id="acuentasoles" wire:model.lazy="acuentasoles">
                            @error('acuentasoles')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="saldosoles" class="form-label">SALDO S/:</label>
                            <input type="number" class="form-control" name="saldosoles" id="saldosoles" wire:model.defer="saldosoles" disabled>
                            @error('saldosoles')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div> --}}
                        <div class="mb-3 col-md-2">
                            <label for="totalsoles" class="form-label">COUNTER:</label>
                            <div wire:ignore>
                                <select class="form-control" name="userId" id="userId" wire:model.defer="userId">
                                    <option value="" >SELECCIONE</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if($totaldolares > 0)
                        <div class="mb-3 col-md-2">
                            <label for="totaldolares" class="form-label">SUB-TOTAL $:</label>
                            <input type="number" class="form-control" name="totaldolares" id="totaldolares" wire:model.defer="totaldolares" disabled>
                            @error('totaldolares')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
                        @if($totalsoles > 0)
                        <div class="mb-3 col-md-2">
                            <label for="totalsoles" class="form-label">SUB-TOTAL S/:</label>
                            <input type="number" class="form-control" name="totalsoles" id="totalsoles" wire:model.defer="totalsoles" disabled>
                            @error('totalsoles')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
                    </div>
                    @endif
                    @if($tipoReserva==0)
                    <div class="row flex justify-content-end">
                        <div class="mb-3 col-md-2">
                            <label for="totalsoles" class="form-label">COUNTER:</label>
                            <div wire:ignore>
                                <select class="form-control" name="userId" id="userId" wire:model.defer="userId">
                                    <option value="" >SELECCIONE</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="totaldolares" class="form-label">TOTAL $:</label>
                            <input type="number" class="form-control" name="totaldolares" id="totaldolares" wire:model="totaldolares">
                            @error('totaldolares')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="totalsoles" class="form-label">TOTAL S/:</label>
                            <input type="number" class="form-control" name="totalsoles" id="totalsoles" wire:model="totalsoles">
                            @error('totalsoles')
                                <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @endif
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
                                        @if($tipoReserva==1)
                                            <th><label class="form-label"> PRECIO</label></th>
                                        @endif
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
                                        <td style="width:100px"><input type="number" class="form-control" placeholder="Nº" name="cantidadsevicio[]" id="cantidadsevicio.{{$j}}" wire:model.defer="cantidadsevicio.{{$j}}">
                                            @error('cantidadsevicio.'.$i)
                                                <span class="error-message" style="color:red">Campo Obligatorio</span>
                                            @enderror
                                        </td>
                                        <td >
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
                                        @if($tipoReserva==1)
                                            <td>
                                                <input type="number" class="form-control" name="precio_operacion[]" id="precio_operacion.{{$j}}" wire:model.lazy="precio_operacion.{{$j}}" step="0.01" placeholder="Precio">
                                                @error('precio_operacion.'.$j)
                                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                                @enderror
                                            </td>
                                        @endif
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
                            @if($totalservicios > 0)
                                <div class="row flex justify-content-end">
                                    <div class="mb-3 col-md-4">
                                        <label for="totalservicios" class="form-label">SUB-TOTAL SERVICIOS S/:</label>
                                        <input type="number" class="form-control" name="totalservicios" id="totalservicios" wire:model.defer="totalservicios" disabled>
                                        @error('totalservicios')
                                            <span class="error-message" style="color:red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div><!-- Col -->
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3">PAGOS</h4>
                    <span class="form-label">
                        @if($reservasoles > 0)
                            S/ {{$reservasoles}}
                        @endif

                        @if($reservasoles > 0 && $reservadolares > 0)
                            /
                        @endif

                        @if($reservadolares > 0)
                            $ {{$reservadolares}}
                        @endif
                    </span>
                    <div class="col-md-12 mb-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><label class="form-label"> MONEDA</label></th>
                                        <th><label class="form-label"> CUENTA</label></th>
                                        <th><label class="form-label"> MONTO</label></th>
                                        <th>
                                            @if($totalsoles > 0 || $totaldolares > 0)
                                                @if($cont3<1)
                                                    <button type="button"  data-bs-toggle="tooltip" data-bs-title="Aumentar" class="btn btn-success btn-icon" wire:click="aumentarPago">+</button>
                                                @else
                                                    <button type="button"  data-bs-toggle="tooltip" data-bs-title="Reducir" class="btn btn-danger btn-icon" wire:click="reducirPago">-</button>
                                                @endif
                                            @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($k=0;$k<$cont3;$k++)
                                    <tr>
                                        <td>
                                            <div wire:ignore>
                                                <select class="form-select" name="monedapago[]" id="monedapago.{{$k}}" wire:model="monedapago.{{$k}}">
                                                    @foreach($monedas as $moneda)
                                                        <option value="{{$moneda->id}}" >{{$moneda->abreviatura}} {{$moneda->nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('monedapago.'.$k)
                                                <span class="error-message" style="color:red">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <div wire:ignore>
                                                <select class="form-control" name="cuenta_id[]" id="cuenta_id{{$k}}" wire:model.defer="cuenta_id.{{$k}}">
                                                    <option value="" >SELECCIONE...</option>
                                                </select>
                                            </div>
                                                @error('cuenta_id.'.$k)
                                                    <span class="error-message" style="color:red">{{ $message }}</span>
                                                @enderror

                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="monto[]" id="monto.{{$k}}" wire:model.lazy="monto.{{$k}}" step="0.01" placeholder="Monto">
                                            @error('monto.'.$k)
                                                <span class="error-message" style="color:red">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            @if($k==$cont3-1)
                                                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Aumentar" class="btn btn-success btn-icon" wire:click="aumentarPago">+</button>
                                            @else
                                                <button type="button"  data-bs-toggle="tooltip" data-bs-title="Reducir" class="btn btn-danger btn-icon" wire:click="reducirPago">-</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                                <tfoot>
                                    @if($reservasoles > 0)
                                        <tr>
                                            <td>A cuenta: S/ {{$pagosoles}}</td>
                                            <td>Saldo: S/ {{$reservasoles-$pagosoles}}</td>
                                            <td>Total: S/ {{$reservasoles}}</td>
                                        </tr>
                                    @endif
                                    @if($reservadolares > 0)
                                        <tr>
                                            <td>A cuenta: $ {{$pagodolares}}</td>
                                            <td>Saldo: $ {{$reservadolares-$pagodolares}}</td>
                                            <td>Total: $ {{$reservadolares}}</td>
                                        </tr>
                                    @endif
                                </tfoot>
                            </table>
                        </div>
                    </div><!-- Col -->
                </div>
            </div>
        </div>
    </div>
    <div class="row flex justify-content-end">
        <div class="col-md-1  flex justify-content-end">
            <button type="submit" class="btn btn-primary me-2 ">Guardar</button>
        </div>
    </div>
</div>
@push('custom-scripts')
@for($i=0;$i<$cont;$i++)
<script>
    $('#tour_id{{$i}}').val('{{$tour_id[$i]}}').select2();
    $('#tour_id{{$i}}').on('change',function(){
        @this.set('tour_id.{{$i}}',this.value);
    });

    $('#hotel_id{{$i}}').select2({
        tags: true,
    });
    $('#hotel_id{{$i}}').on('change',function(){
        @this.set('hotel_id.{{$i}}',this.value);
    });
</script>
@endfor
@for($i=0;$i<$cont2;$i++)
<script>
    $('#servicio_id{{$i}}').val('{{$servicio_id[$i]}}').select2();
    $('#servicio_id{{$i}}').on('change',function(){
        @this.set('servicio_id.{{$i}}',this.value);
    });
</script>
@endfor
@for($i=0;$i<$cont3;$i++)
<script>
    $('#cuenta_id{{$i}}').val('{{$cuenta_id[$i]}}').select2();
    $('#cuenta_id{{$i}}').on('change',function(){
        @this.set('cuenta_id.{{$i}}',this.value);
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

$('#userId').val('{{$userId}}').select2();
$('#userId').on('change',function(){
    @this.set('userId',this.value);
});

Livewire.on('aumentarTour', function (id) {
        $('#tour_id'+id).select2();
        $('#tour_id'+id).on('change', function (e) {
            @this.set('tour_id.'+id, this.value);
        });
});

Livewire.on('aumentarServicios', function (id) {
        $('#servicio_id'+id).select2();
        $('#servicio_id'+id).on('change', function (e) {
            @this.set('servicio_id.'+id, this.value);
        });
});

Livewire.on('aumentarPagos', function (id,datos) {
        $('#cuenta_id'+id).empty();
        $('#cuenta_id'+id).select2({
            data: datos,
        });
        $('#cuenta_id'+id).on('change', function (e) {
            @this.set('cuenta_id.'+id, this.value);
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
