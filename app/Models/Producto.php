<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'nombre',
        'cantidad',
        'costo_adquisicion',
        'precio_venta',
        'proveedor_id',
    ];
    public function proveedor() {
        return $this->belongsTo(Proveedor::class);
    }
    public function ventas() {
        return $this->hasMany(Venta::class);
    }
    public function listaDeseos() {
        return $this->hasMany(ListaDeseos::class);
    }
    public function actualizarStock($cantidad)
    {
        $this->update(['cantidad' => $cantidad]);

        if ($cantidad > 0) {
            $clientes = ListaDeseos::where('producto_id', $this->id)
                                ->with('cliente.user')
                                ->get();

            foreach ($clientes as $lista) {
                $lista->cliente->user->notify(new StockDisponibleNotification($this));
            }
        }
    }
    
    
}
