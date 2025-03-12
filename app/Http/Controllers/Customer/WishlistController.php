<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlists = auth()->user()->wishlists()
            ->with('wishlistItems.product')
            ->latest()
            ->paginate(6);
            
        return view('customer.wishlists.index', compact('wishlists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.wishlists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        // Establecer is_public en false si no se proporciona
        $validated['is_public'] = $request->has('is_public') ? true : false;

        $wishlist = auth()->user()->wishlists()->create($validated);

        return redirect()->route('customer.wishlists.show', $wishlist)
            ->with('success', 'Lista de deseos creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wishlist $wishlist)
    {
        // Verificar que la lista de deseos pertenezca al usuario autenticado
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $wishlist->load('wishlistItems.product');
        $products = Product::where('active', true)->get();

        return view('customer.wishlists.show', compact('wishlist', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wishlist $wishlist)
    {
        // Verificar que la lista de deseos pertenezca al usuario autenticado
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        return view('customer.wishlists.edit', compact('wishlist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        // Verificar que el usuario actual es el propietario de la lista
        if ($wishlist->user_id !== auth()->id()) {
            return redirect()->route('customer.wishlists.index')
                ->with('error', 'No tienes permiso para editar esta lista de deseos.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        // Establecer is_public en false si no se proporciona
        $validated['is_public'] = $request->has('is_public') ? true : false;

        $wishlist->update($validated);

        return redirect()->route('customer.wishlists.show', $wishlist)
            ->with('success', 'Lista de deseos actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wishlist $wishlist)
    {
        // Verificar que la lista de deseos pertenezca al usuario autenticado
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $wishlist->delete();

        return redirect()->route('customer.wishlists.index')
            ->with('success', 'Lista de deseos eliminada exitosamente.');
    }

    /**
     * Agregar un producto a la lista de deseos.
     */
    public function addProduct(Request $request, Wishlist $wishlist)
    {
        // Verificar que la lista de deseos pertenezca al usuario autenticado
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        // Verificar si el producto ya está en la lista de deseos
        $exists = $wishlist->wishlistItems()
            ->where('product_id', $request->product_id)
            ->exists();

        if (!$exists) {
            $wishlist->wishlistItems()->create([
                'product_id' => $request->product_id,
                'notified' => false,
            ]);

            return redirect()->back()->with('success', 'Producto agregado a la lista de deseos.');
        }

        return redirect()->back()->with('info', 'El producto ya está en la lista de deseos.');
    }

    /**
     * Eliminar un producto de la lista de deseos.
     */
    public function removeProduct(Wishlist $wishlist, WishlistItem $item)
    {
        // Verificar que la lista de deseos pertenezca al usuario autenticado
        if ($wishlist->user_id !== auth()->id() || $item->wishlist_id !== $wishlist->id) {
            abort(403);
        }

        $item->delete();

        return redirect()->back()->with('success', 'Producto eliminado de la lista de deseos.');
    }
}
