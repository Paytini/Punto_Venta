<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    //
    public function productos() {
        return $this->hasMany(Producto::class);
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    
}
