<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard del cliente.
     */
    public function index()
    {
        $user = auth()->user();
        $wishlists = $user->wishlists()->with('wishlistItems.product')->get();
        $featuredProducts = Product::where('active', true)->latest()->take(6)->get();
        
        // Verificar si hay productos en stock de la lista de deseos
        $notifiedItems = [];
        foreach ($wishlists as $wishlist) {
            foreach ($wishlist->wishlistItems as $item) {
                if ($item->product->stock > 0 && !$item->notified) {
                    $notifiedItems[] = $item;
                    $item->update(['notified' => true]);
                }
            }
        }

        return view('customer.dashboard', compact(
            'wishlists',
            'featuredProducts',
            'notifiedItems'
        ));
    }
}
