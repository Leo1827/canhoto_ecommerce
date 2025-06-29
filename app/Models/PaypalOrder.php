<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaypalOrder extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'order_id',
        'payer_id',
        'payer_name',
        'payer_email',
        'amount',
        'currency',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
