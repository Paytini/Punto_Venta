<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold">Lista de Proveedores</h1>
            <a href="{{ route('proveedores.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Nuevo Proveedor</a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-4">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Teléfono</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proveedores as $proveedor)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $proveedor->nombre }}</td>
                            <td class="px-4 py-2">{{ $proveedor->email }}</td>
                            <td class="px-4 py-2">{{ $proveedor->telefono }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('proveedores.edit', $proveedor) }}" class="text-blue-500">Editar</a>
                                <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" class="inline">
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
