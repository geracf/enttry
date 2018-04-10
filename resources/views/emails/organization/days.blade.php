@component('mail::message')
# Quedan sólo {{ $organization->remaining_days }} para que tu cuenta expire.

Para continuar accediendo a JobsHere agrega otro plan, todos los procesos y días restantes se sumarán!

Gracias,<br>
{{ config('app.name') }}
@endcomponent
