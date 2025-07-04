<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vintage extends Model
{
    //
    protected $fillable = ['year'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
