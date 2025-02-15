<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Agregar Nuevo Producto</h1>

        <form action="{{ route('productos.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block">Nombre:</label>
                <input type="text" name="nombre" class="w-full border p-2">
            </div>

            <div class="mb-4">
                <label class="block">Cantidad:</label>
                <input type="number" name="cantidad" class="w-full border p-2">
            </div>

            <div class="mb-4">
                <label class="block">Costo de Adquisición:</label>
                <input type="number" step="0.01" name="costo_adquisicion" class="w-full border p-2">
            </div>

            <div class="mb-4">
                <label class="block">Precio de Venta:</label>
                <input type="number" step="0.01" name="precio_venta" class="w-full border p-2">
            </div>

            <div class="mb-4">
                <label class="block">Proveedor:</label>
                <select name="proveedor_id" class="w-full border p-2">
                    @foreach(App\Models\Proveedor::all() as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Guardar</button>
        </form>
    </div>
</x-app-layout>
