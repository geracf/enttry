@component('mail::message')
# Hola, {{ $user->name }}

Para ingresar a JobsHere es necesario que confirmes tu cuenta!.

@component('mail::button', ['url' => url("confirm/$user->activation_id")])
Da click aquí
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
