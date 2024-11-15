@component('mail::message')
# Contacto desde la Web
# Nombre:
{{$request->nombre}}
# Email:
{{$request->email}}
# Celular:
{{$request->celular}}
@component('mail::panel')
{{$request->mensaje}}
@endcomponent
@endcomponent