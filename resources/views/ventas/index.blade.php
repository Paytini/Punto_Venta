<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold">Ventas Registradas</h1>
            <a href="{{ route('ventas.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Nueva Venta</a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-4">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="px-4 py-2">Producto</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Cliente</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas as $venta)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $venta->producto->nombre }}</td>
                            <td class="px-4 py-2">{{ $venta->cantidad }}</td>
                            <td class="px-4 py-2">${{ $venta->total }}</td>
                            <td class="px-4 py-2">{{ $venta->cliente ? $venta->cliente->user->name : 'Venta sin cliente' }}</td>
                            <td class="px-4 py-2">
                                <form action="{{ route('ventas.destroy', $venta) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 ml-2">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
