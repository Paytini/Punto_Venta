<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistorialComprasController extends Controller
{
    public function index()
    {
        $ventas = Auth::user()->cliente->ventas()->with('producto')->get();
        return view('clientes.historial', compact('ventas'));
    }
}
