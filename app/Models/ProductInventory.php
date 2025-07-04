<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductInventory extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'quantity',
        'price',
        'limited',
        'minimum'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
