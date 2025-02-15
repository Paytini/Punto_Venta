<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id'];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function listaDeseos() {
        return $this->hasMany(ListaDeseos::class);
    }
    public function ventas() {
        return $this->hasMany(Venta::class);
    }
    public function productosComprados()
    {
        return $this->hasManyThrough(Producto::class, Venta::class, 'cliente_id', 'id', 'id', 'producto_id');
    }
    
}
