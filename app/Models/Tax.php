<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    //
    protected $fillable = [
        'name',
        'rate',
    ];

    // 🔹 Relación con Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
