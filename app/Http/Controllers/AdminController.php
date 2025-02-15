<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Venta;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsuarios' => User::count(),
            'totalProductos' => Producto::count(),
            'totalProveedores' => Proveedor::count(),
            'totalVentas' => Venta::count()
        ]);
    }
}
