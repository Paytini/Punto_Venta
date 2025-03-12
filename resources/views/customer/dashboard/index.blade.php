<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard de Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(count($notifiedItems) > 0)
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">¡Buenas noticias!</strong>
                    <span class="block sm:inline">Los siguientes productos de tu lista de deseos ya están disponibles:</span>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach($notifiedItems as $item)
                            <li>{{ $item->product->name }} - <a href="{{ route('customer.wishlists.show', $item->wishlist) }}" class="underline">Ver en lista de deseos</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Mis Listas de Deseos</h3>
                        <a href="{{ route('customer.wishlists.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Crear Lista de Deseos
                        </a>
                    </div>

                    @if($wishlists->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($wishlists as $wishlist)
                                <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                    <div class="bg-gray-50 px-4 py-2 border-b">
                                        <h4 class="font-semibold">{{ $wishlist->name }}</h4>
                                    </div>
                                    <div class="p-4">
                                        <p class="text-sm text-gray-600 mb-2">{{ $wishlist->description ?: 'Sin descripción' }}</p>
                                        <p class="text-sm text-gray-500">{{ $wishlist->wishlistItems->count() }} productos</p>
                                        <div class="mt-4">
                                            <a href="{{ route('customer.wishlists.show', $wishlist) }}" class="text-blue-600 hover:underline">Ver detalles</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No tienes listas de deseos. ¡Crea una ahora!</p>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Productos Destacados</h3>
                    
                    @if($featuredProducts->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($featuredProducts as $product)
                                <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-400">Sin imagen</span>
                                        </div>
                                    @endif
                                    <div class="p-4">
                                        <h4 class="font-semibold text-lg mb-1">{{ $product->name }}</h4>
                                        <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->description, 100) }}</p>
                                        <div class="flex justify-between items-center mt-4">
                                            <span class="text-lg font-bold">${{ number_format($product->price, 2) }}</span>
                                            <span class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $product->stock > 0 ? 'En stock: ' . $product->stock : 'Agotado' }}
                                            </span>
                                        </div>
                                        
                                        @if($wishlists->count() > 0)
                                            <div class="mt-4">
                                                <div class="mb-2">
                                                    <label for="wishlist-select-{{ $product->id }}" class="block text-sm font-medium text-gray-700 mb-1">Seleccionar lista de deseos:</label>
                                                    <select id="wishlist-select-{{ $product->id }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                        @foreach($wishlists as $wishlist)
                                                            <option value="{{ $wishlist->id }}">{{ $wishlist->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <form id="add-to-wishlist-form-{{ $product->id }}" action="{{ route('customer.wishlists.add-product', $wishlists->first()) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <button type="button" onclick="addToWishlist({{ $product->id }})" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded shadow-md transition duration-150 ease-in-out flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                                        </svg>
                                                        Agregar a Lista de Deseos
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <div class="mt-4">
                                                <a href="{{ route('customer.wishlists.create') }}" class="block text-center w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded shadow-md transition duration-150 ease-in-out">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    Crear Lista de Deseos
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No hay productos destacados disponibles.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function addToWishlist(productId) {
            const selectElement = document.getElementById(`wishlist-select-${productId}`);
            const wishlistId = selectElement.value;
            const form = document.getElementById(`add-to-wishlist-form-${productId}`);
            form.action = form.action.replace(/\/\d+\/add-product/, `/${wishlistId}/add-product`);
            form.submit();
        }
    </script>
</x-app-layout> 