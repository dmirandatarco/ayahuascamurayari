<!-- Navbar top start-->
<div class="navbar-top d-none d-lg-block">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <!-- navbar top Left-->
            <div class="d-flex align-items-center">
                <!-- Language -->

                <!-- Top info -->
                <ul class="nav list-unstyled ml-3">
                    <li class="nav-item mr-3"> <a class="navbar-link" href="#"><strong>{{ __('Telefono')}}:</strong> (51) 992 790 571</a> </li>
                    <li class="nav-item mr-3"> <a class="navbar-link" href="#"><strong>Email:</strong> reservas@dayexpeditionscusco.com</a> </li>
                </ul>
            </div>
            <!-- navbar top Right-->
            <div class="d-flex align-items-center">
                <!-- Top Account -->
                <!-- top link -->

                <!-- top social -->
                <ul class="social-icons">
                    <li class="social-icons-item social-facebook m-0"> <a class="social-icons-link w-auto px-2" target="_blank" href="https://www.facebook.com/DayEXpeditionsTravel"><i class="fab fa-facebook-f"></i></a> </li>
                    <li class="social-icons-item social-facebook m-0"> <a class="social-icons-link w-auto px-2" target="_blank" href="https://www.instagram.com/dayexpeditionscusco/"><i class="fab fa-instagram"></i></a> </li>
                    <li class="social-icons-item social-twitter m-0"> <a class="social-icons-link w-auto pl-2" target="_blank" href="https://www.tiktok.com/@dayexpeditionscusco"><i class="fab fa-tiktok"></i></a> </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Navbar top End-->

<!-- Logo Nav Start -->
<nav class="navbar navbar-expand-lg z-index-9">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="/"> <img src="{{ asset('img/logo.png')}}" alt="dayexpedition"> </a>
        <!-- Menu opener button -->
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"> <span class="fas fa-bars"></span> </button>

        <!-- Main Menu Start -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto flex align-items-center">
                <!-- Menu item 1 Demos-->
                <li class="nav-item dropdown active"> <a class="nav-link text-capitalize" href="/" id="docMenu" aria-haspopup="true" aria-expanded="false">{{ __('Inicio')}}</a></li>
                <li class="nav-item dropdown"> <a class="nav-link text-capitalize" href="/tours?tabs=on&selectPaquete=1" id="team" aria-haspopup="true" aria-expanded="false">{{ __('Paquetes')}}</a></li>
                <li class="nav-item dropdown"> <a class="nav-link text-capitalize" href="/about" id="team" aria-haspopup="true" aria-expanded="false">{{ __('Nosotros')}}</a></li>
                @foreach(App\Models\Categoria::join('languages','categorias.language_id','=','languages.id')->has('tours')->where('languages.abreviatura',session('lang'))->orderBy('categorias.nombre','asc')->get() as $categoria)
                    <li class="nav-item dropdown  "> <a class="nav-link text-capitalize" href="{{route('web.categoria.show',$categoria)}}" id="docMenu" aria-haspopup="true" aria-expanded="false">{{strtolower($categoria->nombre)}}</a></li>
                @endforeach
                <li class="nav-item dropdown"> <a class="nav-link text-capitalize" href="/contact" id="team" aria-haspopup="true" aria-expanded="false">{{ __('Contactos')}}</a></li>
                {{-- <li class="nav-item dropdown"> <a class="nav-link text-capitalize" href="/team" id="team" aria-haspopup="true" aria-expanded="false">{{ __('Equipo')}}</a></li> --}}
                @livewire('carrito-compra')

                <li class="nav-item dropdown mx-3">
                @foreach($languages as $language)
                            @if($language->abreviatura==App::getLocale())
                                <a class=" nav-link text-capitalize dropdown-toggle" href="/localization?lang={{$language->abreviatura}}" role="button" id="dropdownLanguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="dropdown-item-icon" src="{{asset('storage/img/idioma/'.$language->icono)}}" alt="">
                                </a>
                            @endif
                        @endforeach
                        <div class="dropdown-menu shadow" aria-labelledby="dropdownLanguage">
                            @foreach($languages as $language)
                                @if($language->abreviatura!=App::getLocale())
                                    <a class="dropdown-item" href="/localization?lang={{$language->abreviatura}}">
                                        <img class="dropdown-item-icon" src="{{asset('storage/img/idioma/'.$language->icono)}}" alt="">
                                    </a>
                                @endif
                            @endforeach
                        </div>
                </li>


            </ul>
        </div>
        <!-- Main Menu End -->
        <!-- Header Extras Start-->
        <div class="navbar-nav">
            <!-- extra item Search-->
            {{-- <div class="nav-item search border-0 pl-3 pr-0 px-lg-2" id="search"> </div> --}}
            <!-- extra item Btn-->
            {{-- <div class="nav-item border-0 d-none d-lg-inline-block align-self-center"> <a href="/reserva/checkout" class=" btn btn-sm btn-grad text-white mb-0">Reservar</a> </div> --}}
        </div>
        <!-- Header Extras End-->
    </div>
</nav>
<!-- Logo Nav End -->
