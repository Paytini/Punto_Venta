<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-700">Catálogo de Productos</h1>

            <!-- Icono de Lista de Deseos -->
            <a href="{{ route('lista-deseos.index') }}" class="relative px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-md transition">
                🧡 Lista de Deseos
                @if(session('wishlist_count') > 0)
                    <span class="absolute -top-2 -right-2 bg-white text-red-600 font-bold px-2 py-1 rounded-full text-xs">
                        {{ session('wishlist_count') }}
                    </span>
                @endif
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($productos as $producto)
                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <h2 class="text-xl font-bold">{{ $producto->nombre }}</h2>
                    <p class="text-gray-600">Precio: ${{ number_format($producto->precio_venta, 2) }}</p>

                    <form action="{{ route('lista-deseos.store', $producto) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md shadow-md transition">
                            🧡 Agregar a Lista de Deseos
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
