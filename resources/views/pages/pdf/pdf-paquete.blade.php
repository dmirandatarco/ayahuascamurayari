<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Paquete</title>
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
        font-size: 16px;
        text-align: center;
        font-weight: bold;
        color: #1a62ae;
        margin-bottom: 22px;
    }
    .subtitulotermino{
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 2px;
        margin-top: 19px;
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
        margin-top: 6px;
    }
    li{
        text-align: justify;
        font-size:11px;
        line-height: 14px;
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
    .imagenes-e{
        top: 0cm;
        left: 0px;
        right: 0px;
        z-index: 3;
        margin-top:0px;
        margin-bottom:0px;
        width: 21cm;
        height:29.7cm;
    }
    .sinbordes{
        top: 0cm;
        left: 0px;
        right: 0px;
        z-index: 3;
        margin-top:0px;
        margin-bottom:0px;
    }
    .cuerpo{
        margin-top: 18%;
        margin-bottom: 9%;
    }
</style>
</head>

<body>

    @foreach ( $paquetes->detalles as $paquete )
        <div class="sinbordes">
            <img class="imagenes-e" src="{{asset('storage/img/cotizacion/'.$paquete->tour->voucher)}}">
        </div>
    @endforeach


</body>

</html>
