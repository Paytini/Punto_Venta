<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Proveedor;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('proveedor')->paginate(10);
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        return view('productos.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'costo_adquisicion' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'proveedor_id' => 'required|exists:proveedores,id',
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto agregado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $proveedores = Proveedor::all();
        return view('productos.edit', compact('producto', 'proveedores'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'costo_adquisicion' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'proveedor_id' => 'required|exists:proveedores,id',
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
