<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ListaDeseosController;
use App\Http\Controllers\HistorialComprasController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CatalogoController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // administrador
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('productos', ProductoController::class);
        Route::resource('proveedores', ProveedorController::class);
        Route::resource('ventas', VentaController::class);
    });

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    });
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::resource('usuarios', UsuarioController::class);
    });


    // clientes
    Route::middleware(['auth', 'role:client'])->group(function () {
        Route::get('catalogo', [ListaDeseosController::class, 'index'])->name('catalogo');
        Route::post('lista-deseos/{producto}', [ListaDeseosController::class, 'store'])->name('lista-deseos.store');
        Route::get('lista-deseos', [ListaDeseosController::class, 'index'])->name('lista-deseos.index');
        Route::delete('lista-deseos/{listaDeseo}', [ListaDeseosController::class, 'destroy'])->name('lista-deseos.destroy');
    });

    Route::middleware(['auth', 'role:client'])->group(function () {
        Route::get('historial-compras', [HistorialComprasController::class, 'index'])->name('historial-compras');
    });
    
});

require __DIR__.'/auth.php';
