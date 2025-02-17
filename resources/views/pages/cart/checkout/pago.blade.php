@extends('layouts.checkout')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Método de Pago</h1>

        <form method="POST" action="{{ route('cart.checkout.payment.store') }}">
            @csrf

            <div class="mb-4">
                <h2 class="text-lg font-semibold">Selecciona un método de pago</h2>

                <label class="flex items-center mt-2">
                    <input type="radio" name="payment_method" value="card" checked class="mr-2">
                    <span>Tarjeta de crédito/débito</span>
                </label>

                <label class="flex items-center mt-2">
                    <input type="radio" name="payment_method" value="paypal" class="mr-2">
                    <span>PayPal</span>
                </label>

                <label class="flex items-center mt-2">
                    <input type="radio" name="payment_method" value="bank_transfer" class="mr-2">
                    <span>Transferencia bancaria</span>
                </label>
            </div>

            <!-- Botón para continuar -->
            <div class="mt-6">
                <button type="submit" class="bg-black text-white px-6 py-3 rounded hover:bg-gray-800">
                    Continuar a Revisión
                </button>
            </div>
        </form>
    </div>
@endsection
