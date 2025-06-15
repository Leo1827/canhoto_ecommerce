<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name', 'code', 'driver', 'is_active', 'config'];

    protected $casts = [
        'is_active' => 'boolean',
        'config' => 'array'
    ];

    public function userPayments()
    {
        return $this->hasMany(UserPayment::class, 'method', 'code');
    }
}
