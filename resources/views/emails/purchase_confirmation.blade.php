@component('mail::message')
# ¡Gracias por tu compra!

Hemos recibido tu pago correctamente y tu pedido ha sido procesado con éxito.

Adjuntamos tu **ticket de compra en PDF** con todos los detalles.

Si tienes alguna pregunta, no dudes en contactarnos.

@component('mail::button', ['url' => route('home')])
Volver a la tienda
@endcomponent

Gracias por confiar en TiendaPc.
**TiendaPc - Tu tienda de tecnología**
@endcomponent
