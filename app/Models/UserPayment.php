<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_id',
        'method',
        'amount',
        'currency_id',
        'status',
        'metadata',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getFeaturesListAttribute()
    {
        return explode(',', $this->features);
    }
}
