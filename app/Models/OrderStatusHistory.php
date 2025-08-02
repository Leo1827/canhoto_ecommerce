<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class OrderStatusHistory extends Model
{
    //
    protected $fillable = [
        'order_id',
        'status',
        'description',
        'changed_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
