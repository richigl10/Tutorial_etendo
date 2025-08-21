@component('mail::message')
# ¡Hola!

Este es un correo de prueba enviado desde la plataforma de Inversiones Pucara utilizando Brevo SMTP.

@if(auth()->check())
Usuario: **{{ auth()->user()->name }}**
Correo: **{{ auth()->user()->email }}**
@endif

@component('mail::button', ['url' => url('/')])
Ir al sitio
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
