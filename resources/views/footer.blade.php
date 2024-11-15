<section class="Categories hotelsamilar">
    <div class="container">
        @php
            $certificado = App\Models\Certificacio::join('languages','certificacios.language_id','=','languages.id')->where('languages.abreviatura',session('lang'))->first();
        @endphp
        <div class="row mb-5">
            <div class="col-md-12">
                <h1 class="font-weight lspace-sm text-center titulo">{{$certificado->titulo}}</h1>
                <h3 class="certi-subtitle">{{$certificado->subtitulo}}</h3>
            </div>
        </div>
        <div class="container"style="flex-wrap: nowrap;display: flex;justify-content: center;align-items: center;">
            <div class="certifications-container">
                <div class="lvl4">
                    <picture>
                        <img src="{{asset('storage/img/certificados/'.$certificado->image_1)}}" alt="">
                    </picture>
                </div>
                <div class="lvl3">
                    <picture>
                        <img src="{{asset('storage/img/certificados/'.$certificado->image_2)}}" alt="">
                    </picture>
                </div>
                <div class="lvl2">
                    <picture>
                        <img src="{{asset('storage/img/certificados/'.$certificado->image_3)}}" alt="">
                    </picture>
                </div>
                <div class="lvl1">
                    <picture>
                        <img src="{{asset('storage/img/certificados/'.$certificado->image_4)}}" alt="">
                    </picture>
                </div>
                <div class="lvl2">
                    <picture>
                        <img src="{{asset('storage/img/certificados/'.$certificado->image_5)}}" alt="">
                    </picture>
                </div>
                <div class="lvl3">
                    <picture>
                        <img src="{{asset('storage/img/certificados/'.$certificado->image_6)}}" alt="">
                    </picture>
                </div>
                <div class="lvl4">
                    <picture>
                        <img src="{{asset('storage/img/certificados/'.$certificado->image_7)}}" alt="">
                    </picture>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="footerimg" style="background-image: url({{asset('storage/img/imagenes/mountain2.png')}});">

    </div>
<footer class="footer footer-dark position-relative">
  <div class="footer-content">

    <div class="container pt-5 ">
      <div class="row">
        <!-- Footer widget 3 -->
        <div class="col-md-4 col-sm-4 order-sm-5">
          <div class="widget">
            <h6>{{ __('Ubicanos en')}}:</h6>
            <li class="media mb-3"><i class="fa-solid fa-map-location-dot mr-3 display-8"></i>Calle Plateros 358, Cusco </li></a>
            <div class="contact-map overflow-hidden">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1884.4433245225914!2d-71.98075271711845!3d-13.51573722555504!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x916dd6739684c2db%3A0x35c4eedce6633158!2sDay%20Expedition%20Travel!5e0!3m2!1ses-419!2spe!4v1653544480347!5m2!1ses-419!2spe"  style="border:0; width:100%; height:320px;" allowfullscreen></iframe>
            </div>
          </div>
        </div>
        <!-- Footer widget 5 -->
        <div class="col-md-4 col-sm-6 order-sm-2">
          <div class="widget address">
            <ul class="list-unstyled">
              <h6>{{ __('Contactos')}}</h6>
              <a href="tel:991134356" target="_blank"><li class="media mb-3"><i class="fas fa-phone mr-3 display-8"></i>+51 991 134 356 </li></a>
              <a href="tel:968172019" target="_blank"><li class="media mb-3"><i class="fas fa-phone mr-3 display-8"></i>+51 968 172 019 </li></a>
              <a href="tel:992790571" target="_blank"><li class="media mb-3"><i class="fas fa-phone mr-3 display-8"></i>+51 992 790 571 </li></a>
              <a href="tel:956233666" target="_blank"><li class="media mb-3"><i class="fas fa-phone mr-3 display-8"></i>+51 956 233 666</li></a>
              <a href="mailto:info@dayexpeditionscusco.com" target="_blank"><li class="media mb-3"><i class="mr-3 display-8 fa-solid fa-envelope"></i> info@dayexpeditionscusco.com </li></a>
              <a href="mailto:reservas@dayexpeditionscusco.com" target="_blank"><li class="media mb-3"><i class="mr-3 display-8 fa-solid fa-envelope"></i> reservas@dayexpeditionscusco.com </li></a>
              <a href="mailto:dayexpeditionscusco@gmail.com" target="_blank"><li class="media mb-3"><i class="mr-3 display-8 fa-solid fa-envelope"></i> dayexpeditionscusco@gmail.com</li></a>
                <p>Lunes - Domingos: <strong>07:00 - 22:00</strong> <br>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 order-sm-3">
          <div class="widget">
            <h6>{{ __('Siguenos')}}</h6>
            <ul class="social-icons">
              <li class="social-icons-item social-facebook m-0"> <a class="social-icons-link w-auto px-2" target="_blank" href="https://www.facebook.com/DayEXpeditionsTravel"><i class="fab fa-facebook-f"></i></a> </li>
              <li class="social-icons-item social-facebook m-0"> <a class="social-icons-link w-auto px-2" target="_blank" href="https://www.instagram.com/dayexpeditionscusco/"><i class="fab fa-instagram"></i></a> </li>
              <li class="social-icons-item social-twitter m-0"> <a class="social-icons-link w-auto pl-2" target="_blank" href="https://www.tiktok.com/@dayexpeditionscusco"><i class="fab fa-tiktok"></i></a> </li>
              <li class="social-icons-item social-twitter m-0"> <a class="social-icons-link w-auto pl-2" target="_blank" href="https://www.tiktok.com/@dayexpeditionscusco"><i class="fab fa-youtube"></i></a> </li>
            </ul></br>
            <h6>{{ __('Medios de Pagos')}}</h6>
            <form id="frmRegister" action="https://secure.paytoperu.com/eng/customize" method="POST" name="frmRegister" target="_blank">Click en la Imagen para depositar

                <input id="ruc" name="ruc" type="hidden" value="20603327412" />
                <input id="moneda" name="moneda" type="hidden" value="2" />
                <input id="descripcion" name="descripcion" type="hidden" value="Servicios Turisticos" />
                <input title="Payments with pay to peru" alt="PayToPeru.com - The easy and safe way to make payments" height="auto" src="{{ asset('storage/img/medios-de-pago.webp')}}" width="60%" type="image" align="center" />
            </form>
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="divider mt-3"></div>
  <!--footer copyright -->
  <div class="footer-copyright py-3">
    <div class="container">
      <div class="d-md-flex justify-content-between align-items-center py-3 text-center text-md-left">
        <!-- copyright text -->
        <div class="copyright-text">©{{ now()->year }} Todos los derechos reservados por Day Expeditions Travel E.I.R.L. </div>
        {{-- - <a href="http://ideascusco.com/" target="_blank"> Grupo Ideas Cusco</a> --}}
        <!-- copyright links-->

      </div>
    </div>
  </div>
</footer>
