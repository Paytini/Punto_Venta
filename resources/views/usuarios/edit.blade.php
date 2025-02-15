<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 shadow-md rounded-lg">
        <h1 class="text-3xl font-bold text-gray-700 mb-6 text-center">Editar Usuario</h1>

        <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Nombre</label>
                <input type="text" name="name" value="{{ $usuario->name }}" class="w-full border p-2 rounded-md">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Correo Electrónico</label>
                <input type="email" name="email" value="{{ $usuario->email }}" class="w-full border p-2 rounded-md">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Rol</label>
                <select name="role" class="w-full border p-2 rounded-md">
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $usuario->hasRole($role->name) ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('usuarios.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md shadow-md">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow-md">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
