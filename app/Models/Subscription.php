<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'name',
        'stripe_id',
        'stripe_status',
        'stripe_price',
        'trial_ends_at',
        'ends_at',
        'quantity'
    ];

    protected $dates = [
        'trial_ends_at',
        'ends_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function payment()
    {
        return $this->belongsTo(UserPayment::class, 'payment_id', 'payment_id');
    }

    public function history()
    {
        return $this->hasMany(SubscriptionHistory::class);
    }

    public function isActive()
    {
        return $this->stripe_status === 'active' && 
               ($this->ends_at === null || $this->ends_at->isFuture());
    }
}
