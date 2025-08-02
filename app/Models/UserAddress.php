<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    //
    use HasFactory;

    protected $table = 'user_addresses';

    protected $fillable = [
        'user_id',
        'full_name',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fullAddress()
    {
        return "{$this->address}, {$this->city}, {$this->state}, {$this->country}, {$this->postal_code}";
    }

}
