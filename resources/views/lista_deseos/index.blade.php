<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-4">Mi Lista de Deseos</h1>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-4">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="px-4 py-2">Producto</th>
                        <th class="px-4 py-2">Cantidad Deseada</th>
                        <th class="px-4 py-2">Stock Disponible</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lista as $item)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $item->producto->nombre }}</td>
                            <td class="px-4 py-2">{{ $item->cantidad }}</td>
                            <td class="px-4 py-2">{{ $item->producto->cantidad > 0 ? 'Disponible' : 'Agotado' }}</td>
                            <td class="px-4 py-2">
                                <form action="{{ route('lista-deseos.destroy', $item) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 ml-2">Eliminar</button>
                                </form>
                                @if ($item->producto->cantidad > 0)
                                    <span class="text-green-500 ml-2">Producto en Stock</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
