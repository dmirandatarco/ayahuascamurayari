<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="login-box Booking-box">
                <ul id="progressbar" class="text-center mb-3">
                    <li class="active" id="account"><strong>{{ __('Actividades')}}</strong></li>
                    @if($num_formulario>=2)
                        <li class="active"  id="personal"><strong>{{ __('Información Personal')}}</strong></li>
                    @else
                        <li id="personal"><strong>{{ __('Información Personal')}}</strong></li>
                    @endif
                    @if($num_formulario>=3)
                        <li class="active"  id="payment"><strong>{{ __('Pago')}}</strong></li>
                    @else
                        <li id="payment"><strong>{{ __('Pago')}}</strong></li>
                    @endif
                </ul>
                <br>
                @if($num_formulario==1)
                    @forelse (Cart::content() as $item)
                        <div class="row listroBox mt-3">
                            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 Nopadding">
                                @if($item->options->tipo==0)
                                    <figure>  <img src="{{asset('storage/img/tours/'.$item->options->image)}}" class="img-fluid" alt="{{$item->options->image}}" >

                                    </a> </figure>
                                @else
                                    <figure> <img src="{{asset('storage/img/paquetes/'.$item->options->image)}}" class="img-fluid" alt="{{$item->options->image}}" >

                                    </a> </figure>
                                @endif
                            
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12 Nopadding">
                                <div class="listroBoxmain">
                                    <div class="row">
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                                            <h3><a href="{{route('web.tour.show',$item->id)}}">{{$item->name}}</a></h3>
                                        </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                        <a class="bg-danger text-center p-2 text-white rounded cursor-pointer" wire:click="delete('{{$item->rowId}}')">X</a>
                                    </div>
                                </div>
                                <div class="divider mb-3"></div>
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                            <p class="icono-checkout" >{{$item->qty}} {{ __('Pasajeros')}}</p>
                                            <p class="icono-checkout" >{{$item->price}} {{ __('por persona')}}</p>
                                            <p class="icono-checkout" >Fecha: {{$item->options->fecha}} </p>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 text-right">
                                            <h2 class="mb-2 mt-5">{{ __('Sub-Total')}}</h2>
                                            <h2><strong class="bg-success text-white p-1 rounded"> $ {{number_format($item->qty*$item->price,2)}}</strong></h2>
                                        </div>
                                    </div>
                                    <div class="divider mb-3">

                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="login-top">
                                <h3>{{ __('NO EXISTE NINGUN ACTIVIDAD')}}</h3>
                                <p>{{ __('Agrege alguna actividad para poder continuar')}}.</p>
                            </div>
                        </div>
                    @endforelse
                @endif
                @if($num_formulario==2)
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="login-top">
                            <h3 class="mb-3">{{ __('INGRESE LA INFORMACION DE LOS PASAJEROS')}}</h3>
                            @for($i=0;$i<$pax;$i++)
                                <div class="row mb-3">
                                    <div class="col-md-1">
                                        <label class="form-label">#</label>
                                        <input type="text" disabled value="{{$i+1}}" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">{{ __('Nombres')}}(*)</label>
                                        <input type="text" wire:model.lazy="name.{{$i}}"  class="form-control" >
                                        @error('name.'.$i)
                                            <span class="error-message" style="color:red">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label class="form-label">{{ __('Documento')}}(*)</label>
                                        <select class="custom-select select-big mb-3" wire:model.lazy="doc.{{$i}}"  data-live-search >
                                            <option value="" >{{ __('SELECCIONE')}}</option>
                                            <option value="DNI">DNI</option>
                                            <option value="PASAPORTE">PASAPORTE</option>
                                            <option value="CARNET">CARNET</option>
                                            <option value="RUC">RUC</option>
                                        </select>
                                        @error('doc.'.$i)
                                            <span class="error-message" style="color:red">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Nº {{ __('Documento')}}(*)</label>
                                        <input type="text" wire:model.lazy="nume_doc.{{$i}}"  class="form-control" >
                                        @error('nume_doc.'.$i)
                                            <span class="error-message" style="color:red">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="pais_id" class="form-label">{{ __('NACIONALIDAD')}}:</label>
                                        <select class="custom-select select-big mb-3" name="pais" id="pais" wire:model.lazy="pais.{{$i}}">
                                            <option value="" >{{ __('SELECCIONE')}}</option>
                                            @foreach($paises as $pais)
                                                <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                                            @endforeach
                                        </select>
                                        @error('pais.'.$i)
                                            <span class="error-message" style="color:red">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endfor
                            <h3 class="mb-3">{{ __('INGRESE LA INFORMACION CONTACTO')}}</h3>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">{{ __('Nombres')}}(*)</label>
                                    <input type="text" wire:model.lazy="name_titular"  class="form-control" >
                                    @error('name_titular')
                                        <span class="error-message" style="color:red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label class="form-label">{{ __('Celular')}}(*)</label>
                                    <input type="text" wire:model.lazy="phone_titular"  class="form-control" >
                                    @error('phone_titular')
                                        <span class="error-message" style="color:red">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label class="form-label">E-mail(*)</label>
                                    <input type="text" wire:model.lazy="email_titular"  class="form-control" >
                                    @error('email_titular')
                                        <span class="error-message" style="color:red">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($num_formulario==3)
                    <div class="row listroBox mt-3">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 Nopadding text-right p-3">
                            <span class="mb-2 mt-5 mr-5 text-total">{{ __('Total')}}</span><span class="text-total"><strong class="bg-success text-white p-2 rounded"> $ {{Cart::subTotal()}}</strong></span>
                        </div>
                    </div>
                    <form method="POST" action="https://secure.paytoperu.com/eng/payments" id="frmRegister" name="frmRegister" target="_blank">
                        <p>
                            <input type="hidden" name="keymerchant" id="keymerchant" value="20603327412">
                            <input type="hidden" name="codigo_transaccion" id="codigo_transaccion" value="{{$pago?->id}}">
                            <input type="hidden" name="importe" id="importe" value="{{$pago?->monto}}">
                            <input type="hidden" name="items" id="items" value="1">
                            <input type="hidden" name="moneda" id="moneda" value="{{$pago?->moneda_id}}">
                            <input type="hidden" name="email" id="email" value="{{$reserva?->pasajero->email}}">
                            <input type="hidden" name="nombres" id="nombres" value="{{$reserva?->pasajero->nombre}}">
                            <input type="hidden" name="apellidos" id="apellidos" value="">
                            <input type="hidden" name="descripcion" id="descripcion" value="Servicios Turisticos">
                        </p>
                        @if($num_formulario==3)
                            <button type="button"  data-bs-toggle="tooltip" data-bs-title="Pagar" class="btn btn-success" style="margin-left: 15px;" wire:click="pagarpaytoperu">{{ __('PAGAR')}}</button>
                        @endif
                    </form>
                @endif
                @if(Cart::count())
                    @if($num_formulario==1)
                        <div class="row listroBox mt-3">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 Nopadding text-right p-3">
                                <span class="mb-2 mt-5 mr-5 text-total">{{ __('Total')}}</span><span class="text-total"><strong class="bg-success text-white p-2 rounded"> $ {{Cart::subTotal()}}</strong></span>
                            </div>
                        </div>
                    @endif
                    <div class="button-final-form">
                        @if($num_formulario==2 || $num_formulario==3 )
                            <button type="button"   data-bs-toggle="tooltip" data-bs-title="Anterior" class="btn btn-danger" wire:click="disminuirStep">{{ __('ANTERIOR')}}</button>
                        @endif
                        @if($num_formulario==1 || $num_formulario==2 )
                            <button type="button"  data-bs-toggle="tooltip" data-bs-title="Siguiente" class="btn btn-success" wire:click="aumentarStep" style="margin-left: 15px;">{{ __('SIGUIENTE')}}</button>
                        @endif
                        
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@push('custom-scripts')

<script>
Livewire.on('enviar-formulario', function (id,datos) {
    var formulario = document.getElementById("frmRegister");
    formulario.submit();
    window.location.href = "{{ route('welcome') }}";
});
</script>
@endpush
