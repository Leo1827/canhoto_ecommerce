<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceStore extends Model
{
    //
    use HasFactory;

    protected $table = 'invoices_store';

    protected $fillable = [
        'user_id',
        'order_id',
        'invoice_number',
        'client_name',
        'client_email',
        'billing_address',
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

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
}
