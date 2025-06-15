<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name', 
        'stripe_id',
        'price',
        'interval',
        'features',
        'is_active',
        'order'
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
