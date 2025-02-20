@extends('layouts.app')

@section('title', 'Pago Cancelado')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 text-center">
    <h1 class="text-red-600 text-3xl font-bold">¡Pago Cancelado!</h1>
    <p class="mt-4 text-lg text-gray-600">Parece que has cancelado el pago. Si fue un error, puedes intentarlo de nuevo.</p>
    <a href="{{ route('checkout') }}" class="mt-6 inline-block bg-blue-500 text-white px-6 py-2 rounded-lg shadow">
        Intentar de nuevo
    </a>
</div>
@endsection
