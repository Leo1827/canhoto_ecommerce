<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SubscriptionHistory extends Model
{
    //
    use HasFactory;

    protected $table = 'subscription_history';

    protected $fillable = [
        'user_id',
        'subscription_id',
        'status',
        'description', 
        'subscribed_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
