<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Winery extends Model
{
    //
    protected $fillable = ['name', 'slug'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
