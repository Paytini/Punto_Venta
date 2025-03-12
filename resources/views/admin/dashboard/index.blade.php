<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard de Administrador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="bg-blue-100 p-4 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-2">Total de Productos</h3>
                            <p class="text-3xl font-bold">{{ $totalProducts }}</p>
                            <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">Ver productos</a>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-2">Total de Proveedores</h3>
                            <p class="text-3xl font-bold">{{ $totalSuppliers }}</p>
                            <a href="{{ route('admin.suppliers.index') }}" class="text-green-600 hover:underline mt-2 inline-block">Ver proveedores</a>
                        </div>
                        <div class="bg-purple-100 p-4 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-2">Total de Ventas</h3>
                            <p class="text-3xl font-bold">{{ $totalSales }}</p>
                            <a href="{{ route('admin.sales.index') }}" class="text-purple-600 hover:underline mt-2 inline-block">Ver ventas</a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-lg shadow border">
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Ventas Recientes</h3>
                            @if($recentSales->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Factura</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($recentSales as $sale)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <a href="{{ route('admin.sales.show', $sale) }}" class="text-blue-600 hover:underline">
                                                            {{ $sale->invoice_number }}
                                                        </a>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ $sale->customer ? $sale->customer->user->name : 'Sin cliente' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        ${{ number_format($sale->total, 2) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ $sale->created_at->format('d/m/Y H:i') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-500">No hay ventas recientes.</p>
                            @endif
                        </div>

                        <div class="bg-white p-4 rounded-lg shadow border">
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Productos con Stock Bajo</h3>
                            @if($lowStockProducts->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($lowStockProducts as $product)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ $product->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ $product->sku }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock == 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                            {{ $product->stock }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-500">No hay productos con stock bajo.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 