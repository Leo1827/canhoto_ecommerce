<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $fillable = [
        'user_id',
        'subscription_id',
        'invoice_number',
        'client_name',
        'client_email',
        'amount',
        'currency',
        'payment_method',
        'status',
        'issue_date',
        'due_date',
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
