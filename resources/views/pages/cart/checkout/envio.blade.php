@extends('layouts.checkout')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">

        <livewire:address-manager />



        <!-- Botón para continuar -->
        <div class="mt-6">
            <a href="{{ route('cart.checkout.entrega') }}" class="bg-black text-white px-6 py-3 rounded hover:bg-gray-800">
                Continuar a Opciones de Entrega
            </a>
        </div>
    </div>
@endsection
