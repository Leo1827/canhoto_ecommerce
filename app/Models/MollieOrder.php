<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MollieOrder extends Model
{
    //
    protected $fillable = [
        'user_id',
        'plan_id',
        'payment_id',
        'status',
        'amount',
        'currency',
    ];
}
