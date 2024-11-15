<div>
    @forelse (Cart::content() as $item)
    <div class="row listroBox mt-3 mb-3">
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 Nopadding">
        <figure>  <a href="{{route('web.tour.show',$item->id)}}"><img src="{{asset('storage/img/imagenes/'.$item->options->image)}}" class="img-fluid" alt="{{$item->options->image}}" >
            
            </a> </figure>
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
                        <p class="icono-checkout" >{{$item->qty}} Pasajeros</p> 
                        <p class="icono-checkout" >{{$item->price}} por persona</p> 
                        <p class="icono-checkout" >Fecha: {{$item->options->fecha}} </p> 
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 text-right">
                        <h2 class="mb-2 mt-5">Sub-Total</h2>
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
            <h3>NO EXISTE NINGUN ACTIVIDAD</h3>
            <p>Agrege alguna actividad para poder continuar.</p>
        </div>
    </div>
    @endforelse
</div>