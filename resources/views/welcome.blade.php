@extends('layout.web')
@push('head')

@endpush


@section('contenido')

@if ($cabecera)
    @if ($cabecera->tipo == '0')
        <section >

            <div style="height:95%; object-fit:cover;margin-top: -110px;">
                <video muted autoplay loop style="width:100%;object-fit: cover;max-height: 95vh;">
                    <source src="{{asset('storage/img/cabecera/'.$cabecera->video)}}">
                </video>
            </div>
            <div class="transparency-box"></div>
        </section>
    @else
        <section>
            <swiper-container class="mySwiper1" style="--swiper-pagination-bottom:3rem; height:95%; object-fit:cover;margin-top: -110px;" pagination="true" pagination-clickable="true" navigation="true" space-between="30"
                centered-slides="true" autoplay-delay="2500" autoplay-disable-on-interaction="false" >
                @foreach ($cabecera->images as $image)
                <swiper-slide  style="height:100vh;background-image:url({{asset('storage/img/cabecera/'.$image->nombre)}});">    </swiper-slide>
                @endforeach
            </swiper-container>
            <div class="transparency-box"></div>
        </section>
    @endif
@else
        <section>
            <!--DEFAULT-->
            <swiper-container class="mySwiper1" style="--swiper-pagination-bottom:3rem; height:95%; object-fit:cover;margin-top: -110px;" pagination="true" pagination-clickable="true" navigation="true" space-between="30"
                centered-slides="true" autoplay-delay="2500" autoplay-disable-on-interaction="false" >
                <swiper-slide  style="height:100vh;background-image:url({{asset('storage/img/imagenes/cusco.jpg')}});">    </swiper-slide>
                <swiper-slide  style="height:100vh;background-image:url({{asset('storage/img/imagenes/laguna-de-humantay.jpg')}});">    </swiper-slide>
                <swiper-slide  style="height:100vh;background-image:url({{asset('storage/img/imagenes/montana-de-colores.jpg')}});">    </swiper-slide>
            </swiper-container>
            <div class="transparency-box"></div>
        </section>
@endif



<section class=" booking-search">
    <form action="{{route('web.tour.index')}}" method="get" enctype="multipart/form-ta">
    <div class="container ">
        <div class="row shadow border-radius-3 rowsearchwelcom" >
            <div class="col-md-12 np">
                <div class="feature-box h-100" style="border-radius: 5px;">
                    <div class="tab_container">
                        <input id="tab5" type="radio" name="tabs" checked>
                        <section id="content5" class="tab-content">
                            @livewire('search-tour')
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</section>

<section class="Categories pb60 hotelsamilar" style="margin-top:100px">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <h1 class="paddtop1 font-weight lspace-sm text-center titulo">{{ __('Tours Destacados')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="swiper-container guides-slider-popular">
                <!-- Additional required wrapper-->
                <div id="carrosultour" class="owl-carousel">
                    <!-- Slides-->
                    @foreach($tour as $to)
                    <div class="swiper-slide h-auto px-2">
                        <div class="listing-item ">
                            <article class="TravelGo-category-listing fl-wrap">
                                <a href="{{route('web.tour.show',$to)}}">
                                    <div class="TravelGo-category-img">
                                        <img src="{{asset('storage/img/tours/'.$to->imagenprincipal)}}" alt="">
                                        <div class="TravelGo-category-opt">
                                            @foreach($to->ranking($to->id) as $ran)
                                            <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                                @for($i=0;$i<$ran->promedio;$i++)
                                                    <i class="fa fa-star"></i>
                                                    @endfor
                                            </div>
                                            <div class="rate-class-name">
                                                <div class="score"><strong>Very Good</strong>
                                                    {{$ran->total}} Comentarios
                                                </div>
                                                <span>{{round($ran->promedio)}}.0</span>
                                            </div>
                                            @endforeach
                                        </div>
                                </a>
                        </div>

                        <div class="TravelGo-category-content fl-wrap title-sin_item">
                            <div class="TravelGo-category-content-title fl-wrap">
                                <div class="TravelGo-category-content-title-item">
                                    <a href="{{route('web.tour.show',$to)}}">
                                        <h3 class="title-sin_map">
                                            {{$to->nombre}}
                                        </h3>
                                    </a>
                                    <div class="TravelGo-category-location fl-wrap">
                                        <a href="{{route('web.categoria.show',$to->categoria)}}">
                                            {{$to->categoria->nombre}}&nbsp;&nbsp;
                                        </a>
                                        <span>$ {{$to->precio}}</span>
                                    </div>
                                </div>
                            </div>
                            <div style="display: inline-table">
                                <div class="container">
                                {!! Str::limit($to->descripcion,80,'...')!!}
                                </div>
                            </div>

                            <div class="TravelGo-category-footer fl-wrap">
                                <div class="TravelGo-category-price btn-grad">
                                    <span>
                                        <span>{{$to->duracion}} {{$to->unidad}}</span>
                                    </span>
                                </div>
                                {{-- <div class="TravelGo-opt-list">
                                    <a href="#" class="single-map-item"><i class="fas fa-map-marker-alt"></i><span class="TravelGo-opt-tooltip">On the map</span></a>
                                    <a href="#" class="TravelGo-js-favorite"><i class="fas fa-heart"></i><span class="TravelGo-opt-tooltip">Save</span></a>
                                    <a href="#" class="TravelGo-js-booking"><i class="fas fa-retweet"></i><span class="TravelGo-opt-tooltip">Find Directions</span></a>
                                </div> --}}
                            </div>

                        </div>

                        </article>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    </div>
</section>

<section class="Categories pb60 hotelsamilar">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <h1 class="font-weight lspace-sm text-center titulo">{{ __('Tours por todo el Perú')}}</h1>
            </div>
        </div>
        <swiper-container class="mySwiper" pagination="true" pagination-dynamic-bullets="true" effect="coverflow" grab-cursor="true" centered-slides="true"
            slides-per-view="auto" coverflow-effect-rotate="50" autoplay-delay="1000" coverflow-effect-stretch="0" coverflow-effect-depth="100"
            coverflow-effect-modifier="1" coverflow-effect-slide-shadows="true" style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff; ">
            @foreach ($ubicaciones as $ubicacion)
                <swiper-slide >
                    <a href="{{route('web.destino.show',$ubicacion)}}">
                        <div class="card-slide" style="background-image:url({{asset('storage/img/ubicaciones/'.$ubicacion?->image?->nombre)}})">
                                <div class="overlay-slide">
                                <h2>{{$ubicacion?->nombre}}</h2>
                                </div>
                        </div>
                    </a>
                </swiper-slide>
            @endforeach
        </swiper-container>
    </div>
</section>



<div class="innerpage-banner main-features-list-tour left mt-100" style="background:url({{asset('storage/img/nosotros/'.$nosotros->image_principal)}}) repeat;height:70vh;background-attachment: fixed;background-position: center;background-repeat: no-repeat;background-size: cover;">
    <div class="container">
        <div class="row all-text-white rowporqueday">
            <div class="col-md-7 align-items-center align-self-center">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" >
                    <div class="carousel-inner ">
                        <div class="carousel-item active">
                            <img class="d-block w-100 class imgporqueday" src="{{asset('storage/img/nosotros/'.$nosotros->image_secundaria)}}" alt="First slide" >
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-md-5 p-4 colortextwhy align-self-center">

                <a href="{{route('web.about.index')}}">
                    <h3 class="textotituloporqueday">{{ $nosotros->titulo}}</h3><br>

                </a>
                <p class="textoparrafoporqueday " >
                                    {!! $nosotros->descripcion !!}
                </p>
            </div>
        </div>
    </div>
</div>



<section class="Categories hotelsamilar pt-4">
    <div class="container">

        <div class="containerpaquete">
            <div class="row mb-5">
                <div class="col-md-12">
                    <h1 class=" pt20 font-weight lspace-sm text-center titulo">{{ __('Paquete realizados a tu medida')}}</h1>
                </div>
                <div class="swiper-container guides-slider-popular">
                    <!-- Additional required wrapper-->
                    <swiper-container class="mySwiperPaquetes mySwipercard" init="false" autoplay-delay="2500" autoplay-disable-on-interaction="false">
                        @foreach($paquetes as $paquete)
                        <swiper-slide>
                            <div class="col-lg-12 col-md-12"  style="padding: 20px;">
                                <a href="{{route('web.paquete.show',$paquete)}}" class="package-card card-immersive">
                                    <div class="package-card-heading">
                                        <div class="package-card-image">
                                            <img src="{{asset('storage/img/paquetes/'. $paquete->imgprincipal)}}" alt="">
                                        </div>
                                        <div class="package-card-content-pack">
                                        <p class="title-package packagedetails1line">{{ $paquete->nombre }}</p>
                                        </div>
                                        <div class="package-card-details">
                                            <span class="fa-icon fa_so tour-duration">{{ $paquete->dia}}D / {{ $paquete->dia - 1}}N </span>
                                            <span class="fa-icon fa_ss tour-people">Max. {{ $paquete->cantidad }} personas</span>
                                            <span class="fa-icon  fa_so tour-level">Paquete</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </swiper-slide>
                        @endforeach
                    </swiper-container>
                </div>
            </div>
        </div>
        <div class="container">
</section>

<section class="Categories pt80 pb60">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <h1 class="paddtop1 font-weight lspace-sm text-center titulo">{{ __('Testimonios')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="swiper-container guides-slider-popular" style="padding: 20px;">
                <!-- Additional required wrapper-->
                <div id="carrosultestimonios" class="owl-carousel">
                    <!-- Slides-->
                    @foreach(App\Models\Tripadvisor::where('estado',1)->get() as $tripadvisor)
                    <div class="card review-pax-box-outer">
                        <div class="card-body review-pax-box" style="padding-top: 80px;">
                            <div class="pax-avatar">
                                <img class="rounded-circle" alt="20x20" src="{{$tripadvisor->url}}" data-holder-rendered="true" style="width: 110px;">
                            </div>

                            <div class="review-company">
                                <img src="https://theharbourmarbella.com/wp-content/uploads/2018/03/TA_logo_primary.png" style="width: 90px;height: 15px;">
                            </div>

                            <h5 class="card-title" style="font-weight: 900;margin-bottom: 0px !important;">{{$tripadvisor->title}}</h5>
                            <div style="color: #00aa6c;">
                                @for($i=0;$i<$tripadvisor->rating;$i++)
                                    <span class="fa fa-circle"></span>
                                @endfor
                            </div>
                            <p class="card-text" style="overflow: hidden;  text-overflow: ellipsis;  display: -webkit-box;  -webkit-box-orient: vertical;  -webkit-line-clamp: 5;">{{$tripadvisor->description}}</p>
                            <div style="display: flex;flex-wrap: nowrap;justify-content: space-between;align-items: center;">
                                <p style="color: #898989;font-weight: 700;padding: 0;margin: 0;"><span class="fa fa-calendar"></span> {{$tripadvisor->fecha}}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-element-bundle.min.js"></script>

@endpush



@push('scripts')
<script>
    $('#carrosultour').owlCarousel({
        margin: 10,
        nav: true,
        loop: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplaySpeed: 500,
        touchDrag  : true,
        mouseDrag  : true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
    $('#carrosultestimonios').owlCarousel({
        margin: 10,
        nav:true,

        loop: true,
        autoplay: true,
        autoplayTimeout: 2500,
        autoplaySpeed: 2500,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

</script>

<script>
    $('#carrosuldestacada').owlCarousel({
        margin: 10,
        nav: false,
        loop: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplaySpeed: 500,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
</script>

<script>
    window.onload = function() {
        $('.sliderx').slick({
            autoplay: true,
            autoplaySpeed: 1500,
            arrows: true,
            prevArrow: '  <a class="carousel-control-prev" style="filter: invert(100%);left: -10%;" href="#carouselExampleControls" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a>',
            nextArrow: '<a class="carousel-control-next" style="filter: invert(100%);left: 95%;" href="#carouselExampleControls" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a>',
            centerMode: true,
            slidesToShow: 4,
            slidesToScroll: 2
        });

        $('.slidery').slick({
            autoplay: true,
            autoplaySpeed: 1500,
            arrows: true,
            prevArrow: '  <a class="carousel-control-prev" style="filter: invert(100%);left: -10%;" href="#carouselExampleControls" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a>',
            nextArrow: '<a class="carousel-control-next" style="filter: invert(100%);left: 95%;" href="#carouselExampleControls" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a>',
            centerMode: true,
            slidesToShow: 3,
            slidesToScroll: 1
        });

        $('.sliderz').slick({
            autoplay: true,
            autoplaySpeed: 1500,
            arrows: true,
            prevArrow: '  <a class="carousel-control-prev" style="filter: invert(100%);left: -10%;" href="#carouselExampleControls" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a>',
            nextArrow: '<a class="carousel-control-next" style="filter: invert(100%);left: 95%;" href="#carouselExampleControls" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a>',
            centerMode: true,
            slidesToShow: 3,
            slidesToScroll: 1
        });
    };


</script>
<script>
    const swiperEl = document.querySelector('.mySwiperPaquetes');
    Object.assign(swiperEl, {
    slidesPerView: 1,
    spaceBetween: 10,
    breakpoints: {
        640: {
        slidesPerView: 2,
        spaceBetween: 20,
        },
        768: {
        slidesPerView: 2,
        spaceBetween: 10,
        },
        1024: {
        slidesPerView: 3,
        spaceBetween: 10,
        },
    },
    });
    swiperEl.initialize();
</script>




@endpush
@endsection
