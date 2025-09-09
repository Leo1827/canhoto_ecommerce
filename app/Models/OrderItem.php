<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class OrderItem extends Model
{
    //
    protected $fillable = [
        'order_id',
        'user_id',
        'product_id',
        'inventory_id',
        'variant_id',
        'label_item',
        'quantity',
        'discount_status',
        'discount',
        'price_unit',
        'total',
        'tax_id',
        'tax_rate',
        'tax_amount',
    ];

    // Relaciones
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(ProductInventory::class, 'inventory_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }


}
