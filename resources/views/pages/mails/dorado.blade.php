@component('mail::message')
# Dorado Lodge
# Nombre:
{{$request->nombre}}
# Email:
{{$request->email}}
# Celular:
{{$request->celular}}
# Tipo Habitacion:
{{$request->tipoHabitacion}}
# Fecha:
{{$request->fechaIngreso}} al {{$request->fechaSalida}}
@component('mail::panel')
{{$request->mensaje}}
@endcomponent
@endcomponent