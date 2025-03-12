<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with(['customer', 'user'])->latest()->paginate(10);
        return view('admin.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::with('user')->get();
        $products = Product::where('active', true)->where('stock', '>', 0)->get();
        return view('admin.sales.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'tax_rate' => 'required|numeric|min:0|max:100',
        ]);

        try {
            DB::beginTransaction();

            // Generar número de factura único
            $invoiceNumber = 'INV-' . Str::upper(Str::random(8));

            // Calcular subtotal, impuestos y total
            $subtotal = 0;
            foreach ($request->products as $product) {
                $productModel = Product::findOrFail($product['id']);
                $subtotal += $productModel->price * $product['quantity'];
            }

            $taxRate = $request->tax_rate / 100;
            $tax = $subtotal * $taxRate;
            $total = $subtotal + $tax;

            // Crear la venta
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'customer_id' => $request->customer_id,
                'invoice_number' => $invoiceNumber,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'status' => 'completed',
                'notes' => $request->notes,
            ]);

            // Crear los detalles de la venta y actualizar el inventario
            foreach ($request->products as $product) {
                $productModel = Product::findOrFail($product['id']);
                
                // Verificar stock disponible
                if ($productModel->stock < $product['quantity']) {
                    throw new \Exception("Stock insuficiente para el producto: {$productModel->name}");
                }

                // Crear detalle de venta
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $productModel->price,
                    'subtotal' => $productModel->price * $product['quantity'],
                ]);

                // Actualizar inventario
                $productModel->stock -= $product['quantity'];
                $productModel->save();
            }

            DB::commit();

            return redirect()->route('admin.sales.show', $sale)
                ->with('success', 'Venta realizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al realizar la venta: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->load(['customer.user', 'user', 'saleDetails.product']);
        return view('admin.sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        // No permitimos editar ventas completadas
        if ($sale->status === 'completed') {
            return redirect()->route('admin.sales.show', $sale)
                ->with('error', 'No se pueden editar ventas completadas.');
        }

        $sale->load(['customer', 'saleDetails.product']);
        $customers = Customer::with('user')->get();
        $products = Product::where('active', true)->get();
        
        return view('admin.sales.edit', compact('sale', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        // No permitimos actualizar ventas completadas
        if ($sale->status === 'completed') {
            return redirect()->route('admin.sales.show', $sale)
                ->with('error', 'No se pueden actualizar ventas completadas.');
        }

        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'status' => 'required|in:completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $sale->update([
            'customer_id' => $request->customer_id,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.sales.show', $sale)
            ->with('success', 'Venta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        // En lugar de eliminar, cambiamos el estado a cancelado
        // y devolvemos los productos al inventario
        try {
            DB::beginTransaction();

            // Devolver productos al inventario
            foreach ($sale->saleDetails as $detail) {
                $product = $detail->product;
                $product->stock += $detail->quantity;
                $product->save();
            }

            // Cambiar estado de la venta
            $sale->update(['status' => 'cancelled']);

            DB::commit();

            return redirect()->route('admin.sales.index')
                ->with('success', 'Venta cancelada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al cancelar la venta: ' . $e->getMessage());
        }
    }
}
