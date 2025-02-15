<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Agregar Nuevo Proveedor</h1>

        <form action="{{ route('proveedores.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block">Nombre:</label>
                <input type="text" name="nombre" class="w-full border p-2">
            </div>

            <div class="mb-4">
                <label class="block">Email:</label>
                <input type="email" name="email" class="w-full border p-2">
            </div>

            <div class="mb-4">
                <label class="block">Teléfono:</label>
                <input type="text" name="telefono" class="w-full border p-2">
            </div>

            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Guardar</button>
        </form>
    </div>
</x-app-layout>
