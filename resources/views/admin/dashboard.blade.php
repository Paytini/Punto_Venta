<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Panel de Administración</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h2 class="text-xl font-bold">Usuarios</h2>
                <p class="text-3xl font-semibold text-blue-500">{{ $totalUsuarios }}</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h2 class="text-xl font-bold">Productos</h2>
                <p class="text-3xl font-semibold text-green-500">{{ $totalProductos }}</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h2 class="text-xl font-bold">Proveedores</h2>
                <p class="text-3xl font-semibold text-yellow-500">{{ $totalProveedores }}</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <h2 class="text-xl font-bold">Ventas</h2>
                <p class="text-3xl font-semibold text-red-500">{{ $totalVentas }}</p>
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('usuarios.index') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition duration-300">
                Gestionar Usuarios
            </a>
            <a href="{{ route('productos.index') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-md transition duration-300">
                Gestionar Productos
            </a>
            <a href="{{ route('proveedores.index') }}" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg shadow-md transition duration-300">
                Gestionar Proveedores
            </a>
            <a href="{{ route('ventas.index') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-md transition duration-300">
                Gestionar Ventas
            </a>
        </div>
    </div>
</x-app-layout>
