<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Registrar Nueva Venta</h1>

        <form action="{{ route('ventas.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block">Producto:</label>
                <select name="producto_id" class="w-full border p-2">
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}">{{ $producto->nombre }} (Stock: {{ $producto->cantidad }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block">Cantidad:</label>
                <input type="number" name="cantidad" min="1" class="w-full border p-2">
            </div>

            <div class="mb-4">
                <label class="block">Cliente (Opcional):</label>
                <select name="cliente_id" class="w-full border p-2">
                    <option value="">Venta sin cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Registrar Venta</button>
        </form>
    </div>
</x-app-layout>
