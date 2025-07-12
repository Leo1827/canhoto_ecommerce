<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'inventory_id',
        'quantity',
        'price_unit',
        'subtotal',
    ];

    /**
     * El usuario dueño del carrito
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Producto que fue agregado al carrito
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Inventario específico (si aplica)
     */
    public function inventory()
    {
        return $this->belongsTo(ProductInventory::class);
    }
}
