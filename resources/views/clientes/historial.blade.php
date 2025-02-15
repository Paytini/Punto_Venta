<x-app-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 py-10">
        <div class="w-full max-w-4xl bg-white shadow-md rounded-lg p-6">
            <h1 class="text-3xl font-bold text-center mb-6">Mis Compras</h1>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-200 text-gray-700">
                            <th class="px-4 py-2">Producto</th>
                            <th class="px-4 py-2">Cantidad</th>
                            <th class="px-4 py-2">Precio Total</th>
                            <th class="px-4 py-2">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $venta->producto->nombre }}</td>
                                <td class="px-4 py-2 text-center">{{ $venta->cantidad }}</td>
                                <td class="px-4 py-2 text-center">${{ number_format($venta->total, 2) }}</td>
                                <td class="px-4 py-2 text-center">{{ $venta->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
