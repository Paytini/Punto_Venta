<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with('supplier')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }


    public function create()
    {
        $suppliers = Supplier::all();
        return view('admin.products.create', compact('suppliers'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'active' => 'boolean',
        ]);

        $data = $request->all();
        
        // Manejar la carga de imágenes
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        // Establecer el valor predeterminado para active
        $data['active'] = $request->has('active');

        $product = Product::create($data);

        return redirect()->route('admin.products.show', $product)
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('supplier');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $suppliers = Supplier::all();
        return view('admin.products.edit', compact('product', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'active' => 'boolean',
        ]);

        $data = $request->all();
        
        // Manejar la carga de imágenes
        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        // Establecer el valor predeterminado para active
        $data['active'] = $request->has('active');

        $product->update($data);

        // Si el stock ha cambiado de 0 a un valor positivo, notificar a los usuarios
        if ($product->stock > 0 && $product->getOriginal('stock') == 0) {
            $this->notifyWishlistUsers($product);
        }

        return redirect()->route('admin.products.show', $product)
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Verificar si el producto está en alguna venta
        if ($product->saleDetails()->count() > 0) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar el producto porque está asociado a ventas.');
        }

        // Eliminar la imagen si existe
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    /**
     * Notificar a los usuarios que tienen el producto en su lista de deseos.
     */
    private function notifyWishlistUsers(Product $product)
    {
        $wishlistItems = WishlistItem::where('product_id', $product->id)
            ->where('notified', false)
            ->get();

        foreach ($wishlistItems as $item) {
            // Marcar como notificado
            $item->update(['notified' => true]);
        }
    }
}
