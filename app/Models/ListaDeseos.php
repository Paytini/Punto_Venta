<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaDeseos extends Model
{
    //
    public function producto() {
        return $this->belongsTo(Producto::class);
    }
    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }
    
}
