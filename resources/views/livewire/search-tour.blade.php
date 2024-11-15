<div>
    <div class="row " style="place-content: center;">
        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-8">
            <div class="form-group">
                <input class="form-control" style="border-radius: 5px;" type="text" placeholder="{{ __('Ejemplo')}}: Machupicchu, Montaña de Colores" name="BuscarTour" wire:model="buscarTour" autocomplete="off">
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
            <div class="form-group">
                <button class="btn btn-primary btn-lg btn-grad" type="submit">{{ __('Buscar')}}</button>
            </div>
        </div>
    </div>
    @if(count($tours))
    <div style="height: 20px;"></div>
        @foreach($tours as $tour)
            <a class="textoanclasearch" href="/tours?tabs=on&BuscarTour={{$tour->nombre}}">
                <div class="container">
                    <div class="row">
                        <div class="col-4 col-md-2">
                            <img class="imgsearch" src="{{asset('storage/img/tours/'. $tour->imagenprincipal)}}" alt="Img Tour">
                        </div>
                        <div class="col-8 col-md-10 align-self-center">
                            <p class="cursor-pointer text-left" >{{$tour->nombre}}</p>
                        </div>
                    </div>
                </div>
            </a>
            <div class="dropdown-divider"></div>
        @endforeach

    @endif

</div>
