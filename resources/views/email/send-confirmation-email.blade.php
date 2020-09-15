@component('mail::message')
# Confirmación de Email

Hola {{ $user->name }}, gracias por registrase en nuestra aplicacion.

Para poder hacer uso de la aplicación necesitamos que confirme el Email.

@component('mail::button', ['url' => route('register.verify', $user->confirmation_code)])
Confirmar Email
@endcomponent

Gracias,<br>
Equipo de Desarrollo
@endcomponent
