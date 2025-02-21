<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Compras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <h1 class="text-2xl font-semibold mb-4">Historial de Compras</h1>

                @if ($payments->isEmpty())
                    <p class="text-gray-600">No tienes compras registradas.</p>
                @else
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 px-4 py-2">Fecha</th>
                                <th class="border border-gray-300 px-4 py-2">Nombre del Producto</th>
                                <th class="border border-gray-300 px-4 py-2">Total</th>
                                <th class="border border-gray-300 px-4 py-2">Descargar Ticket</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr class="text-center">
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $payment->created_at->format('d/m/Y') }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $payment->product_name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $payment->amount }} €</td>

                                    <td class="border border-gray-300 px-4 py-2">
                                        <a href="{{ route('payments.ticket', $payment->id) }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Ticket
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
