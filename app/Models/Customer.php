<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }


    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            SaleDetail::class,
            'sale_id',
            'id',
            'id',
            'product_id'
        )->distinct();
    }
}
