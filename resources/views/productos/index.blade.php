<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between mb-4">
            <h1 class="text-3xl font-bold text-gray-700">Lista de Productos</h1>
            <a href="{{ route('productos.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">+ Nuevo Producto</a>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="border-b bg-gray-200 text-gray-700 uppercase text-sm">
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Cantidad</th>
                        <th class="px-6 py-3">Precio</th>
                        <th class="px-6 py-3">Proveedor</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr class="border-b">
                            <td class="px-6 py-3">{{ $producto->nombre }}</td>
                            <td class="px-6 py-3">{{ $producto->cantidad }}</td>
                            <td class="px-6 py-3">${{ number_format($producto->precio_venta, 2) }}</td>
                            <td class="px-6 py-3">{{ $producto->proveedor->nombre }}</td>
                            <td class="px-6 py-3 text-center">
                                <a href="{{ route('productos.edit', $producto) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Editar</a>
                                <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $productos->links() }}
        </div>
    </div>
</x-app-layout>
