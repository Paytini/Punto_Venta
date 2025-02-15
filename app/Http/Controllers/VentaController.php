<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('producto', 'cliente')->get();
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $productos = Producto::where('cantidad', '>', 0)->get();
        $clientes = Cliente::all();
        return view('ventas.create', compact('productos', 'clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'cliente_id' => 'nullable|exists:clientes,id'
        ]);

        $producto = Producto::find($request->producto_id);

        if ($producto->cantidad < $request->cantidad) {
            return back()->withErrors(['cantidad' => 'No hay suficiente stock del producto.']);
        }

        $total = $producto->precio_venta * $request->cantidad;

        Venta::create([
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'total' => $total,
            'cliente_id' => $request->cliente_id
        ]);

        $producto->actualizarStock($producto->cantidad - $request->cantidad);

        return redirect()->route('ventas.index')->with('success', 'Venta registrada con éxito');
    }

    public function show(Venta $venta)
    {
        return view('ventas.show', compact('venta'));
    }

    public function destroy(Venta $venta)
    {
        $producto = Producto::find($venta->producto_id);
        $producto->increment('cantidad', $venta->cantidad);
        $venta->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada y stock restaurado');
    }
}
