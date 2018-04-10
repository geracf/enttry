@component('mail::message')
# ¡Gracias por crear tu cuenta con nosotros!

Todo está listo para que utilices nuestra plataforma para encontrar a los mejores estudiantes y recién egresados de las Universidades más importantes de México.

¡Da clic en el botón para iniciar sesión en la plataforma!

@component('mail::button', ['url' => url('login')])
Iniciar sesión
@endcomponent

Muchas gracias,<br>
{{ config('app.name') }}
@endcomponent
