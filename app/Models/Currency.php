<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    //
        use HasFactory;

    protected $fillable = ['code', 'name', 'symbol', 'rate', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'rate' => 'float'
    ];

    public function format($amount)
    {
        return $this->symbol . number_format($amount, 2);
    }

    public function userPayments()
    {
        return $this->hasMany(UserPayment::class);
    }
}
