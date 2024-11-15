<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Ticket Reserva</title>
<style>
    @page {
        margin: 0cm 0cm;
    }
    header {
        position: fixed;
        top: 0cm;
        left: 0px;
        right: 0px;
        height: 3cm;
        z-index: 1;
    }
    footer {
        position: fixed; 
        bottom: 0cm; 
        left: 0cm; 
        right: 0cm;
        height: 10cm;
    }
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-size: 0.5rem;
        font-weight: normal;
        line-height: .05;
        color: #151b1e;   
        writing-mode: tb-rl;
        size:landscape;
        width:100%;
        height:100%;
        margin-top: 18%;        
        margin-bottom: 9%;
    }

    main{
        z-index: 2;
        margin-left: 5%;
        margin-right: 5%;
    }
    .logoarriba{
        margin-top:-50%;
        padding-left:35%;
        padding-right:335%;
        width: 230px;
    }
    .textoizquierda{
        color: rgb(113 193 72);
        font-size: 12px;
        top: 85%;
        left: 3%;
        position:absolute;
    }
    .textoizquierdatitulo{
        text-transform: uppercase;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .textoizquierdasecundario{
        text-transform: lowercase;
        text-decoration: none;
        color: rgb(113 193 72);
    }
    .textoderecha{
        color: rgb(113 193 72);
        font-size: 13px;
        top: 85%;
        right: 15%;
        position:absolute;
        line-height: 5px;
    }
    .iconocentro{
        top: 89%;
        right: 38%;
        left: 38%;
        position:absolute;
        
    }
    .iconosociales{
        padding-right: 5px;
        width: 25px;
        height: 25px;
    }
    .tituloreserva{
        font-size: 25px;
        text-align: center;
        font-weight: bold;
        color: #1a62ae;
    }

    .table {
        display: table;
        width: 100%;
        max-width: 100%;
        background-color: transparent;
        border-collapse: collapse;
        font-size: 12px;
        margin-bottom: 20px;
    }
    .table thead {
        display: table-header-group;
        vertical-align: middle;
        border-color: inherit;
        background-color:  #1a62ae;
        color: #ffffff;
        line-height: 1;
        padding: 0.3rem;
        white-space: nowrap;
    }
    
    
    .table-bordered td {
        border: 2px solid #fff;
    }
    
    .table-striped tbody tr:nth-of-type(even) {
        background-color:#76b0ee;;
    }
    .table tbody td {
        vertical-align: middle;
        border-color: inherit;
        line-height: 1;
        padding: 0.3rem;
        border: 2px solid #fff;
    }
    .tablecliente {
        display: table;
        width: 95%;
        max-width: 95%;
        margin-bottom: 1rem;
        font-size:12px;
        vertical-align: center;
        
        margin-left: 3%;
        margin-right: 3%;
    }
    .titulocliente{
        font-weight: bold;
    }
    .subtitulocliente{
        text-decoration: none;
    }
    .tablecliente td,th {
        line-height: 2;
        display: table-cell;
        vertical-align: inherit;
    }
    .page_break {
        page-break-before: always;
    }
    .resumen{
        page-break-inside: avoid;
    }
    .colorrojo{
        color: #ff0000;
    }
    .titulotermino{
        margin-top: -1%;
        font-size: 19px;
        text-align: center;
        font-weight: bold;
        color: #1a62ae;
        margin-bottom: 22px;
        margin-top: 19px;
    }
    .subtitulotermino{
        font-size: 16px !important;
        margin-bottom: 2px;
        margin-top: 19px;
        line-height: 24px !important;
    }
    .parrafotermino{
        padding-left: 15px;
        padding-right: 15px;
        font-size: 11px;
        line-height: 12px;
        text-align: justify;
        margin-top: 8px;
        margin-bottom: 2px;
    }
    ul{
        margin-top: 8px;
    }
    li{
        text-align: justify;
        font-size:16px;
        line-height: 24px;
        padding-right: 30px;
    }
    .finaltexto{
        margin-top:0px;
        margin-bottom:5px;
        text-align: left;
        font-size:14px;
        line-height: 18px;
        font-weight: bold;
        margin-left: 1rem;
        margin-right: 1rem;
    }
</style>
</head>

<body>
<header>
    <div class="header">
        <img src="{{ asset('img/header.png')}}"  alt="admin@bootstrapmaster.com" style="width: 100%;" >
        <img src="{{ asset('img/logo.png')}}"  class="logoarriba"  alt="admin@bootstrapmaster.com">
    </div>
</header>
<footer>
    <div class="footer">
        <div class="">
            <img src="{{ asset('img/footer.png')}}" alt="admin@bootstrapmaster.com" style="width: 100%;" >
            
        </div>
        <div class="textoizquierda">
            <p class="textoizquierdatitulo">Calle Plateros N° 358 - Cusco</p>
            <a href="https://dayexpeditionscusco.com/" target="_blank" class="textoizquierdasecundario"><p >www.dayexpeditionscusco.com</p></a>
        </div>
        <div class="iconocentro">
            <img src="{{$facebook}}"  class="iconosociales"/>
            <img src="{{$instagram}}" class="iconosociales"/>
            <img src="{{$tiktok}}" class="iconosociales"/>
            <img src="{{$whatsapp}}" class="iconosociales"/>
            <a href="https://www.google.com/maps/place/Day+Expedition+Travel/@-13.5156515,-71.9824992,17z/data=!3m1!4b1!4m6!3m5!1s0x916dd6739684c2db:0x35c4eedce6633158!8m2!3d-13.5156567!4d-71.9803105!16s%2Fg%2F11dyp22b_f" target="_blank" >
                <img src="{{$ubicacion}}" class="iconosociales"/>
            </a>
        </div>
        <div class="textoderecha">
            <p class="textoizquierdatitulo">(+51) 992 790 571</p>
            <p class="textoizquierdatitulo">(+51) 991 134 356</p>
        </div>
    </div>
</footer>
<main>
    <div class="container-fluid">
        <h2 class="tituloreserva">CONTRATO DE SERVICIO Nº {{$reserva->id}}</h2>
        <table class="tablecliente">
            <tbody >
                <tr>
                    <td class="titulocliente">CLIENTE:</td>
                    <td class="subtitulocliente">{{$reserva->pasajero->nombre}}</td>
                    <td class="titulocliente">E-MAIL:</td>
                    <td class="subtitulocliente">{{$reserva->pasajero->email}}</td>
                    <td class="titulocliente">CELULAR:</td>
                    <td class="subtitulocliente">{{$reserva->pasajero->celular}}</td>
                </tr>
                <tr>
                    <td class="titulocliente">FECHA:</td>
                    <td class="subtitulocliente">{{date("d-m-Y H:m",strtotime($reserva->fecha))}}</td>
                    <td class="titulocliente">COUNTER:</td>
                    <td class="subtitulocliente">{{$reserva->user->nombre}}</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        
        <table class="table table-bordered table-striped table-sm ">
            <thead>
                <tr>
                    <th style="width: 30px">PAX</th>
                    <th style="width: 70px">FECHA</th>
                    <th style="width: 110px">TOUR</th>
                    <th style="width: 110px">RECOJO</th>
                    @if($reserva->tipo==1)
                    <th style="width: 70px">PRECIO</th>
                    <th style="width: 70px">SUB-TOTAL</th>
                    @endif
                    <th style="width: 200px" >DESCRIPCION</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reserva->detalles as $detalle)
                <tr>
                    <td>{{$detalle->cantidad}}</td>
                    <td>{{date("d-m-Y",strtotime($detalle->fecha_viaje))}}</td>
                    <td>{{$detalle->tour->nombre}}</td>
                    <td>{{$detalle->hotel->nombre}}</td>
                    @if($reserva->tipo==1)
                    <td>{{$detalle->moneda->abreviatura}} {{number_format($detalle->precio,2)}}</td>
                    <td>{{$detalle->moneda->abreviatura}} {{number_format($detalle->precio*$detalle->cantidad,2)}}</td>
                    @endif
                    <td>{{$detalle->observacion}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if(count($reserva->servicios)>0)
        <h2 class="titulocliente">SERVICIOS ADICIONALES</h2>
        <table class="table table-bordered table-striped table-sm ">
            <thead>
                <tr>
                    <th style="width: 30px">CANTIDAD</th>
                    <th style="width: 70px">SERVICIO</th>
                    @if($reserva->tipo==1)
                    <th style="width: 70px">PRECIO</th>
                    @endif
                    <th style="width: 200px" >DESCRIPCION</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reserva->servicios as $servicio)
                    <tr>
                        <td>{{$servicio->pivot->cantidad}}</td>
                        <td>{{$servicio->nombre}}</td>
                        @if($reserva->tipo==1)
                        <td>{{number_format($servicio->pivot->precio_venta,2)}}</td>
                        @endif
                        <td>{{$servicio->pivot->descripcion}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        <table class="tablecliente">
            <tbody>
                @foreach($reserva->totales as $total)
                <tr>
                    <td class="titulocliente">MEDIO PAGO:</td>
                    <td class="subtitulocliente">{{$total->moneda->abreviatura}} {{number_format($total->acuenta,2)}}</td>
                    <td class="titulocliente">A CUENTA:</td>
                    <td class="subtitulocliente">{{$total->moneda->abreviatura}} {{number_format($total->acuenta,2)}}</td>
                    <td class="titulocliente colorrojo">SALDO:</td>
                    <td class="subtitulocliente colorrojo">{{$total->moneda->abreviatura}} {{number_format($total->saldo,2)}}</td>
                    <td class="titulocliente">TOTAL:</td>
                    <td class="subtitulocliente">{{$total->moneda->abreviatura}} {{number_format($total->total,2)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if(count($reserva->pagos)>0)
        <h2 class="titulocliente">PAGOS</h2>
        <table class="table table-bordered table-striped table-sm ">
            <thead>
                <tr>
                    <th><label class="form-label"> FECHA</label></th>
                    <th><label class="form-label"> CUENTA</label></th>
                    <th><label class="form-label"> PRECIO</label></th>
                </tr>
            </thead>
            <tbody>
                @foreach($reserva->pagos as $pago)
                <tr>
                    <td>{{date("d-m-Y",strtotime($pago->fecha))}}</td>
                    <td>{{$pago->medio->nombre}}</td>
                    <td>{{$pago->moneda->abreviatura}} {{number_format($pago->monto,2)}} </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class="page_break">
        <h2 class="titulotermino">POLÍTICAS DE RESERVA - TERMINOS Y CONDICIONES</h2>
        {{-- <h3 class="subtitulotermino">- SOBRE EL MANEJO DE LA INFORMACIÓN DEL PASAJERO:</h3>
        <p class="parrafotermino">Para proceder con la reserva, en DAY EXPEDITION TRAVEL le solicitaremos información personal, 
        la cual será utilizada de manera estrictamente confidencial para los fines antes mencionados:</p> --}}
        <ul class="subtitulotermino">
            <li>La reserva se hace con el 60%, y un día antes el 40% restante.</li>
            <li>Ninguna cancelación de última hora es reembolsable, será considerado no show.</li>
            <li>Toda cancelación deberá realizarse antes de las 24 horas de viaje (esto aplica para todos los tours excepto Machupicchu).</li>
            <li>Cancelación para Machupicchu solo podrá efectuarse con 48 horas de anticipación y tendrá algunas penalidades que deberá asumir 
                el cliente como: Penalidad en tren, perdida de boleto de entrada, entre otros.</li>
            <li>Los reembolsos en caso de ser extranjeros se realizan mediante Western Union (el pasajero deberá asumir el gasto de envío) o en efectivo.</li>
            <li>La agencia no se responsabiliza ni asume ninguna obligación por accidentes, daños, enfermedades, muerte, retrasos que se pudieran presentar 
                en el viaje; tampoco asume responsabilidad por causas de fuerza mayor, huelgas, condiciones ded tiempo, clima, terremotos, situaciones políticas,
                entre otros que determine cancelaciones, cambios, demoras, etc. Asumiendo el cliente todos los gastos extras ocasionados por esta situación.
                <br>Como también la agencia no se responsabiliza por la perdida de vuelos, hospedaje o viajes debido a externalidades ya mencionados.</li>
            <li>Queda prohibido cualquier actitud bélica frente a los semejantes.</li>
            <li>La agencia se reserva el derecho de cancelar o modificar el itinerario programado cuando lo considere que es para mejor desarrollo de los
                servicios y/o por seguridad de los viajeros.</li>
            <li>Es responsabilidad de los pasajeros contar con la documentación apropiada como pasaportes, visas, seguro de viaje, entre otros necesarios.</li>
            <li><b>Day Expedition Travel </b> no se hará responsable por retrasos o gastos debido a documentos inapropiados, documentos caducados o falta de documentos.</li>
        </ul>
        {{-- <h3 class="subtitulotermino">2. PAGO INICIAL Y MÉTODOS DE PAGO:</h3>
        <p class="parrafotermino">Para confirmar la reserva de cualquiera de nuestros servicios, deberá efectuar un pago inicial 
        del 50% del precio total del servicio solicitado.</p>
        <p class="parrafotermino">A continuación le mencionamos nuestros medios de pago:</p>
        <ul>
            <li>Pagos a través de nuestra página web con las siguientes tarjetas: VISA, Mastercard, American 
            Express, Diners Club.</li>
            <li>Pagos online a través de PAY TO PERU.</li>
            <li>Pagos a través de los agentes Western Union o Money Gram.</li>
            <li>Depósitos a través de transferencia bancaria.</li>
        </ul>
        <p class="parrafotermino">Comisiones: Todos los medios de pago generan comisiones, las mismas que varían dependiendo 
        de la modalidad. Por ello es importante recalcar que es el cliente quien asumirá los costos de las 
        mismas.</p>
        <p class="parrafotermino">Tarifas en dólares: Todas las tarifas están expresadas en dólares americanos e incluyen 
        impuestos y tazas aplicables a turistas extranjeros y peruanos no residentes en Perú.
        Confirmación de reserva: Una vez que recibamos su información personal y el pago del 50% por 
        los servicios solicitados, le enviaremos un correo electrónico en las siguientes 24 horas con la 
        Ficha de Confirmación (éste documento incluirá todos los detalles del servicio contratado).</p>
        <h3 class="subtitulotermino">3. PAGO DEL SALDO O REMANENTE:</h3>
        <p class="parrafotermino">El saldo pendiente deberá hacerse efectivo a su arribo a la ciudad del Cusco o antes del inicio de 
        los servicios y en nuestra oficina central.
        <p class="parrafotermino">El incumplimiento del pago del saldo pendiente le imposibilitará ser partícipe de los servicios 
        contratados (en ningún caso la empresa hará reembolso alguno del pago inicial).</p>
        <p class="parrafotermino">Se recomienda hacer el pago del saldo restante en efectivo ya que con el pago con tarjeta se 
        cobrara más el 5% del total.</p>
        <h3 class="subtitulotermino">4. MODIFICACIONES DE ITINERARIOS POR PARTE DEL CLIENTE:</h3>
        <p class="parrafotermino">Cualquier tipo de modificación por parte del cliente genera penalidades las cuales serán 
        asumidas por el mismo cliente. Es importante recalcar que con respecto a los boletos Bus CONSETTUR, boletos de tren e 
        ingresos a Machupicchu, por ningún motivo se permite modificación alguna.</p>
        <p class="parrafotermino">Tampoco NO está PERMITIDO el cambio de titularidad del servicio.</p>
        <h3 class="subtitulotermino">5. CANCELACIÓN DE TOURS</h3>
        <p class="parrafotermino">Si el contrato de servicio se hace un día antes de realizar el tour, no hay devolución de dinero 
        por cancelación. Para cancelar algún tour (excepto algún tour que se relaciones con Machupicchu, Puno, Paracas) 
        se debe realizar con 24 horas de anticipación, caso contrario no se hará ningún tipo de rembolso 
        de dinero.</p>
        <h3 class="subtitulotermino">6. BOLETOS E INGRESOS PARA LOS DIFERENTES TOURS </h3>
        <p class="parrafotermino">Las entradas no están incluidas en los diferentes tours, en caso usted quisiera que le añadan los 
        boletos se debe coordinar con su asesor de ventas para hacer el aumento del monto para los 
        boletos. </p>
        <h3 class="subtitulotermino">7. OTRAS DISPOSICIONES</h3>
        <ul>
            <li>En caso de cierre de fronteras por disposición del estado peruano, se puede realizar una 
            reprogramación de tours dentro del año vigente 2022 o hacer la devolución del monto abonado.</li>
            <li>Cancelación del tour a Machupicchu: tener en cuenta que es un tour que necesita muchos 
            boletos y estos se compran con mucha anticipación, en caso cancele el tour se hará la devolución 
            del dinero con un porcentaje menos por la compra de los boletos que incluye el tour.</li>
            <li>Cancelación de servicio de hospedaje se debe hacer con 15 días de anticipación y solo se hará 
            la devolución del 75% del monto abonado.</li>
            <li>Comisiones: Todos los medios de devolución generan comisiones, las mismas que varían 
            dependiendo de la modalidad. Por ello es importante recalcar que es el cliente quien asumirá 
            los costos de las mismas.</li>
        </ul> --}}
        <p class="finaltexto">Los números de nuestros asesores de venta están disponibles de 7am a 9pm, pasado ese 
        horario ninguno de nuestros asesores se pondrá en contacto.</p>
        <p class="finaltexto " style="color:#2A3787;text-align: center;">Numero de asesor disponible de 4 a 5 am: +51 992 790 571.</p>
    <div>
</main>
</body>

</html>