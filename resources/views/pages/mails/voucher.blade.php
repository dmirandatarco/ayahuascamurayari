@component('mail::message')
# Voucher Day Expeditions Nº {{$reserva->id}}
Hola {{$reserva->pasajero->nombre}} su Reserva y pago se han procesado correctamente muchas gracias.
@endcomponent