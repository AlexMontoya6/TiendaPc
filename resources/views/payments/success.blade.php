<x-app-layout>

<div class="bg-white shadow-md rounded-lg p-6 text-center">
    <h1 class="text-green-600 text-3xl font-bold">¡Gracias por tu compra!</h1>
    <p class="mt-4 text-lg text-gray-600">Tu pago se ha procesado correctamente. Recibirás un correo con los detalles de tu pedido.</p>
    <a href="{{ route('home') }}" class="mt-6 inline-block bg-blue-500 text-white px-6 py-2 rounded-lg shadow">
        Volver a la tienda
    </a>
</div>
</x-app-layout>
