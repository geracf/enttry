@component('mail::message')
# Hola {{ $user->name }}

Recibimos una solicitud de registro de la empresa {{ $organization->name }}.

@component('mail::button', ['url' => url("organization/".$organization->id."/confirm")])
Confirma tu cuenta
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
