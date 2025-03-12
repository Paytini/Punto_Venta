<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nueva Venta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('admin.sales.store') }}" method="POST" id="sale-form">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-1">
                                <div class="mb-4">
                                    <label for="customer_id" class="block text-sm font-medium text-gray-700">Cliente (Opcional)</label>
                                    <select name="customer_id" id="customer_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Sin cliente</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="tax_rate" class="block text-sm font-medium text-gray-700">Tasa de Impuesto (%)</label>
                                    <input type="number" name="tax_rate" id="tax_rate" value="{{ old('tax_rate', 16) }}" min="0" max="100" step="0.01" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('tax_rate')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Notas</label>
                                    <textarea name="notes" id="notes" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-semibold mb-4">Productos</h3>
                                
                                <div class="mb-4">
                                    <label for="product-search" class="block text-sm font-medium text-gray-700">Buscar Producto</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" id="product-search" placeholder="Buscar por nombre o SKU"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <button type="button" id="add-product-btn" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200" id="products-table">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Producto
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Precio
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Cantidad
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Subtotal
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200" id="products-container">
                                            <tr id="empty-row">
                                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                    No hay productos agregados a la venta.
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="bg-gray-50">
                                            <tr>
                                                <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                                    Subtotal:
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" id="subtotal">
                                                    $0.00
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                                    Impuesto:
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" id="tax">
                                                    $0.00
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="px-6 py-4 whitespace-nowrap text-lg font-bold text-gray-900 text-right">
                                                    Total:
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-gray-900" id="total">
                                                    $0.00
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                
                                <div id="products-dropdown" class="hidden absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm max-h-60 overflow-auto">
                                    <!-- Productos se agregarán aquí dinámicamente -->
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.sales.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <button type="submit" id="submit-sale" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" disabled>
                                Completar Venta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const products = @json($products);
            const productSearch = document.getElementById('product-search');
            const productsDropdown = document.getElementById('products-dropdown');
            const productsContainer = document.getElementById('products-container');
            const emptyRow = document.getElementById('empty-row');
            const addProductBtn = document.getElementById('add-product-btn');
            const submitSaleBtn = document.getElementById('submit-sale');
            const taxRateInput = document.getElementById('tax_rate');
            const subtotalElement = document.getElementById('subtotal');
            const taxElement = document.getElementById('tax');
            const totalElement = document.getElementById('total');
            const saleForm = document.getElementById('sale-form');
            
            let selectedProducts = [];
            let filteredProducts = [];
            let selectedProductIndex = -1;
            
            // Función para actualizar los totales
            function updateTotals() {
                let subtotal = 0;
                selectedProducts.forEach(product => {
                    subtotal += product.price * product.quantity;
                });
                
                const taxRate = parseFloat(taxRateInput.value) / 100;
                const tax = subtotal * taxRate;
                const total = subtotal + tax;
                
                subtotalElement.textContent = '$' + subtotal.toFixed(2);
                taxElement.textContent = '$' + tax.toFixed(2);
                totalElement.textContent = '$' + total.toFixed(2);
                
                // Habilitar/deshabilitar botón de envío
                submitSaleBtn.disabled = selectedProducts.length === 0;
            }
            
            // Función para renderizar la tabla de productos
            function renderProductsTable() {
                if (selectedProducts.length === 0) {
                    emptyRow.classList.remove('hidden');
                } else {
                    emptyRow.classList.add('hidden');
                }
                
                // Limpiar filas existentes (excepto la fila vacía)
                const existingRows = productsContainer.querySelectorAll('tr:not(#empty-row)');
                existingRows.forEach(row => row.remove());
                
                // Agregar filas para cada producto seleccionado
                selectedProducts.forEach((product, index) => {
                    const row = document.createElement('tr');
                    
                    const subtotal = product.price * product.quantity;
                    
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="text-sm font-medium text-gray-900">${product.name}</div>
                                <input type="hidden" name="products[${index}][id]" value="${product.id}">
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">$${product.price.toFixed(2)}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="number" name="products[${index}][quantity]" value="${product.quantity}" min="1" max="${product.stock}" 
                                class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                onchange="updateProductQuantity(${index}, this.value)">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">$${subtotal.toFixed(2)}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button type="button" class="text-red-600 hover:text-red-900" onclick="removeProduct(${index})">Eliminar</button>
                        </td>
                    `;
                    
                    productsContainer.appendChild(row);
                });
                
                updateTotals();
            }
            
            // Función para filtrar productos
            function filterProducts(query) {
                if (!query) {
                    filteredProducts = [];
                    productsDropdown.classList.add('hidden');
                    return;
                }
                
                query = query.toLowerCase();
                filteredProducts = products.filter(product => 
                    (product.name.toLowerCase().includes(query) || product.sku.toLowerCase().includes(query)) && 
                    product.stock > 0 && 
                    product.active && 
                    !selectedProducts.some(p => p.id === product.id)
                );
                
                renderProductsDropdown();
            }
            
            // Función para renderizar el dropdown de productos
            function renderProductsDropdown() {
                productsDropdown.innerHTML = '';
                
                if (filteredProducts.length === 0) {
                    productsDropdown.classList.add('hidden');
                    return;
                }
                
                filteredProducts.forEach((product, index) => {
                    const item = document.createElement('div');
                    item.className = `cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-gray-100 ${selectedProductIndex === index ? 'bg-indigo-100' : ''}`;
                    item.dataset.index = index;
                    
                    item.innerHTML = `
                        <div class="flex items-center">
                            <span class="font-medium block truncate">${product.name}</span>
                            <span class="ml-2 text-gray-500 text-sm">SKU: ${product.sku}</span>
                        </div>
                        <span class="text-sm text-gray-500 ml-2">Stock: ${product.stock} | Precio: $${product.price.toFixed(2)}</span>
                    `;
                    
                    item.addEventListener('click', () => {
                        addProductToSale(product);
                        productSearch.value = '';
                        productsDropdown.classList.add('hidden');
                        filteredProducts = [];
                    });
                    
                    productsDropdown.appendChild(item);
                });
                
                productsDropdown.classList.remove('hidden');
            }
            
            // Función para agregar un producto a la venta
            function addProductToSale(product) {
                const productToAdd = {
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    stock: product.stock,
                    quantity: 1
                };
                
                selectedProducts.push(productToAdd);
                renderProductsTable();
            }
            
            // Event listeners
            productSearch.addEventListener('input', () => {
                filterProducts(productSearch.value);
            });
            
            productSearch.addEventListener('keydown', (e) => {
                if (filteredProducts.length === 0) return;
                
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    selectedProductIndex = Math.min(selectedProductIndex + 1, filteredProducts.length - 1);
                    renderProductsDropdown();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    selectedProductIndex = Math.max(selectedProductIndex - 1, 0);
                    renderProductsDropdown();
                } else if (e.key === 'Enter' && selectedProductIndex >= 0) {
                    e.preventDefault();
                    addProductToSale(filteredProducts[selectedProductIndex]);
                    productSearch.value = '';
                    productsDropdown.classList.add('hidden');
                    filteredProducts = [];
                    selectedProductIndex = -1;
                }
            });
            
            addProductBtn.addEventListener('click', () => {
                if (filteredProducts.length > 0) {
                    addProductToSale(filteredProducts[0]);
                    productSearch.value = '';
                    productsDropdown.classList.add('hidden');
                    filteredProducts = [];
                }
            });
            
            taxRateInput.addEventListener('input', updateTotals);
            
            document.addEventListener('click', (e) => {
                if (!productSearch.contains(e.target) && !productsDropdown.contains(e.target)) {
                    productsDropdown.classList.add('hidden');
                }
            });
            
            // Funciones globales para ser accedidas desde los elementos HTML
            window.updateProductQuantity = function(index, quantity) {
                selectedProducts[index].quantity = parseInt(quantity);
                renderProductsTable();
            };
            
            window.removeProduct = function(index) {
                selectedProducts.splice(index, 1);
                renderProductsTable();
            };
            
            // Validación del formulario
            saleForm.addEventListener('submit', (e) => {
                if (selectedProducts.length === 0) {
                    e.preventDefault();
                    alert('Debe agregar al menos un producto a la venta.');
                }
            });
        });
    </script>
</x-app-layout> 