<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard del administrador.
     */
    public function index()
    {
        $totalProducts = Product::count();
        $totalSuppliers = Supplier::count();
        $totalSales = Sale::count();
        $recentSales = Sale::with('customer')->latest()->take(5)->get();
        $lowStockProducts = Product::where('stock', '<', 10)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalSuppliers',
            'totalSales',
            'recentSales',
            'lowStockProducts'
        ));
    }
}
