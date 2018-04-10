@component('mail::message')
# Hola, {{ $student->name }}!

Un empleador vio tu perfil y quiere que apliques a una de sus ofertas.

Además te manda a decir esto:

"{{ $message }}"

¡Da clic en el botón para ir a verla!

@component('mail::button', ['url' => url("offer/$offer->id")])
Ver oferta
@endcomponent

Mucha suerte!<br>
{{ config('app.name') }}
@endcomponent
