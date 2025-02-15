<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListaDeseos;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class ListaDeseosController extends Controller
{
    public function index()
    {
        $lista_deseos = Auth::user()->cliente->listaDeseos()->with('producto')->get();
        return view('clientes.lista_deseos', compact('lista_deseos'));
    }


    public function store(Producto $producto)
    {
        $cliente = Auth::user()->cliente;

        // Verificar si ya está en la lista
        if (!$cliente->listaDeseos()->where('producto_id', $producto->id)->exists()) {
            $cliente->listaDeseos()->create([
                'producto_id' => $producto->id,
                'cantidad' => 1,
            ]);
        }

        // Actualizar contador de lista de deseos
        session(['wishlist_count' => $cliente->listaDeseos()->count()]);

        return redirect()->route('catalogo')->with('success', 'Producto agregado a tu lista de deseos.');
    }

    public function destroy(ListaDeseos $listaDeseo)
    {
        $listaDeseo->delete();

        // Actualizar contador de lista de deseos
        session(['wishlist_count' => Auth::user()->cliente->listaDeseos()->count()]);

        return redirect()->route('lista-deseos.index')->with('success', 'Producto eliminado de la lista de deseos.');
    }
}
