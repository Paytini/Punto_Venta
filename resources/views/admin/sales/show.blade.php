<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Venta #{{ $sale->invoice_number }}
            </h2>
            <div class="flex space-x-2">
                @if($sale->status !== 'cancelled')
                    <form action="{{ route('admin.sales.destroy', $sale) }}" method="POST" onsubmit="return confirm('¿Estás seguro de cancelar esta venta? Se devolverán los productos al inventario.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Cancelar Venta
                        </button>
                    </form>
                @endif
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
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Información de la Venta</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-gray-500 text-sm">Factura</p>
                                    <p class="font-medium">{{ $sale->invoice_number }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Fecha</p>
                                    <p class="font-medium">{{ $sale->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Estado</p>
                                    <p class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sale->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $sale->status === 'completed' ? 'Completada' : 'Cancelada' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Cliente</h3>
                            <div class="space-y-3">
                                @if($sale->customer)
                                    <div>
                                        <p class="text-gray-500 text-sm">Nombre</p>
                                        <p class="font-medium">{{ $sale->customer->user->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-sm">Email</p>
                                        <p class="font-medium">{{ $sale->customer->user->email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-sm">Teléfono</p>
                                        <p class="font-medium">{{ $sale->customer->phone ?: 'No especificado' }}</p>
                                    </div>
                                @else
                                    <p class="text-gray-500">Venta sin cliente registrado</p>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Vendedor</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-gray-500 text-sm">Nombre</p>
                                    <p class="font-medium">{{ $sale->user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Email</p>
                                    <p class="font-medium">{{ $sale->user->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($sale->notes)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-2">Notas</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-700">{{ $sale->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Productos</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Producto
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Precio Unitario
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cantidad
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($sale->saleDetails as $detail)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($detail->product->image)
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $detail->product->image) }}" alt="{{ $detail->product->name }}">
                                                    </div>
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $detail->product->name }}</div>
                                                    <div class="text-sm text-gray-500">SKU: {{ $detail->product->sku }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">${{ number_format($detail->price, 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $detail->quantity }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">${{ number_format($detail->subtotal, 2) }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                        Subtotal:
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ${{ number_format($sale->subtotal, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                        Impuesto:
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ${{ number_format($sale->tax, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-lg font-bold text-gray-900 text-right">
                                        Total:
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-gray-900">
                                        ${{ number_format($sale->total, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between">
                <a href="{{ route('admin.sales.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver a la lista
                </a>
            </div>
        </div>
    </div>
</x-app-layout> 