@component('mail::message')
# Solicitud de cambio de contraseña

Haga clic en el botón para cambiar la contraseña

@component('mail::button', ['url' => 'http://localhost:4200/response-password-reset?token='.$token])
Restablecer la contraseña
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent