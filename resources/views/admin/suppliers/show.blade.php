<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $supplier->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este proveedor?')">
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Información de Contacto</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-gray-500 text-sm">Nombre de Contacto</p>
                                    <p class="font-medium">{{ $supplier->contact_name ?: 'No especificado' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Email</p>
                                    <p class="font-medium">{{ $supplier->email ?: 'No especificado' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Teléfono</p>
                                    <p class="font-medium">{{ $supplier->phone ?: 'No especificado' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Dirección</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-gray-500 text-sm">Dirección</p>
                                    <p class="font-medium">{{ $supplier->address ?: 'No especificada' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Ciudad</p>
                                    <p class="font-medium">{{ $supplier->city ?: 'No especificada' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Estado/Provincia</p>
                                    <p class="font-medium">{{ $supplier->state ?: 'No especificado' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Código Postal</p>
                                    <p class="font-medium">{{ $supplier->postal_code ?: 'No especificado' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($supplier->notes)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-2">Notas</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-700">{{ $supplier->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Productos de este Proveedor</h3>
                    
                    @if($supplier->products->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nombre
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            SKU
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Precio
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Stock
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($supplier->products as $product)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $product->sku }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                ${{ number_format($product->price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ $product->active ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                                <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">Este proveedor no tiene productos registrados.</p>
                    @endif
                </div>
            </div>
            
            <div class="mt-6">
                <a href="{{ route('admin.suppliers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver a la lista
                </a>
            </div>
        </div>
    </div>
</x-app-layout> 