<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    //
    protected $fillable = [
        'status',
        'user_id',
        'user_address_id',
        'user_comment',
        'subtotal',
        'shipping_cost',
        'tax',
        'total',
        'currency_id',
        'payment_method',
        'payment_status',
        'paid_at',
        'cancelled_at',
        'shipped_at',
    ];


    protected $dates = [
        'paid_at',
        'created_at',
        'updated_at',
    ];

    // 🔁 Relaciones

    // Usuario que hizo la orden
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Dirección usada para esta orden
    public function userAddress(): BelongsTo
    {
        return $this->belongsTo(UserAddress::class);
    }

    // Items de la orden (productos)
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id');
    }

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function invoice()
    {
        return $this->hasOne(InvoiceStore::class);
    }


}
