<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Region extends Model
{
    //
    protected $fillable = ['name', 'country' ,'slug'];

    // Slug automático
    protected static function booted()
    {
        static::creating(function ($region) {
            $region->slug = Str::slug($region->name);
        });

        static::updating(function ($region) {
            $region->slug = Str::slug($region->name);
        });
    }
}
