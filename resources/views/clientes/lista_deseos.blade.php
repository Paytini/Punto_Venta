<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Mi Lista de Deseos</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b bg-gray-200 text-gray-700 uppercase text-sm">
                        <th class="px-6 py-3">Producto</th>
                        <th class="px-6 py-3 text-center">Cantidad</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lista_deseos as $item)
                        <tr class="border-b">
                            <td class="px-6 py-3">{{ $item->producto->nombre }}</td>
                            <td class="px-6 py-3 text-center">{{ $item->cantidad }}</td>
                            <td class="px-6 py-3 text-center">
                                <form action="{{ route('lista-deseos.destroy', $item) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md shadow-md transition">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
