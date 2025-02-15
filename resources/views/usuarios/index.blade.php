<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Lista de Usuarios</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b bg-gray-200 text-gray-700 uppercase text-sm">
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Rol</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr class="border-b hover:bg-gray-100 transition">
                            <td class="px-6 py-3">{{ $usuario->name }}</td>
                            <td class="px-6 py-3">{{ $usuario->email }}</td>
                            <td class="px-6 py-3">{{ $usuario->roles->pluck('name')->implode(', ') }}</td>
                            <td class="px-6 py-3 text-center">
                                <a href="{{ route('usuarios.edit', $usuario) }}" class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md shadow-md transition">
                                    Editar
                                </a>
                                <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="inline-block">
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

        <div class="mt-4">
            {{ $usuarios->links() }} <!-- Paginación -->
        </div>
    </div>
</x-app-layout>
