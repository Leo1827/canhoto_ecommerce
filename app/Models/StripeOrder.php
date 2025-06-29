<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class StripeOrder extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'session_id',
        'payment_intent',
        'payer_email',
        'amount',
        'currency',
        'status',
    ];
}
