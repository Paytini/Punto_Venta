<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $product->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.products.edit', $product) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow">
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg">
                                    <span class="text-gray-500">Sin imagen</span>
                                </div>
                            @endif
                            
                            <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">Estado</h3>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Activo:</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $product->active ? 'Sí' : 'No' }}
                                    </span>
                                </div>
                                <div class="flex justify-between mt-2">
                                    <span class="text-gray-700">Stock:</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $product->stock }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Información General</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-gray-500 text-sm">SKU</p>
                                        <p class="font-medium">{{ $product->sku }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-sm">Proveedor</p>
                                        <p class="font-medium">{{ $product->supplier->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-sm">Precio de Venta</p>
                                        <p class="font-medium">${{ number_format($product->price, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-sm">Costo</p>
                                        <p class="font-medium">${{ number_format($product->cost, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-sm">Margen de Ganancia</p>
                                        <p class="font-medium">
                                            @if($product->cost > 0)
                                                {{ number_format((($product->price - $product->cost) / $product->cost) * 100, 2) }}%
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-sm">Fecha de Creación</p>
                                        <p class="font-medium">{{ $product->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-semibold mb-2">Descripción</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-700">{{ $product->description ?: 'Sin descripción' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between">
                <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver a la lista
                </a>
            </div>
        </div>
    </div>
</x-app-layout> 