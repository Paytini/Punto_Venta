<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Editar Proveedor</h1>

        <form action="{{ route('proveedores.update', $proveedor) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block">Nombre:</label>
                <input type="text" name="nombre" value="{{ $proveedor->nombre }}" class="w-full border p-2">
            </div>

            <div class="mb-4">
                <label class="block">Email:</label>
                <input type="email" name="email" value="{{ $proveedor->email }}" class="w-full border p-2">
            </div>

            <div class="mb-4">
                <label class="block">Teléfono:</label>
                <input type="text" name="telefono" value="{{ $proveedor->telefono }}" class="w-full border p-2">
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Actualizar</button>
        </form>
    </div>
</x-app-layout>
