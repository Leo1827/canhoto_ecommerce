<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'winery_id',
        'region_id',
        'wine_type_id',
        'vintage_id',
        'condition_id',
        'name',
        'slug',
        'sku',
        'price',
        'bottling_year',
        'ideal_temperature',
        'alcohol_content',
        'capacity',
        'grape_variety',
        'certification',
        'stock',
        'description',
        'image',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function winery()
    {
        return $this->belongsTo(Winery::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function wineType()
    {
        return $this->belongsTo(WineType::class);
    }

    public function vintage()
    {
        return $this->belongsTo(Vintage::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function inventories()
    {
        return $this->hasMany(ProductInventory::class);
    }

    public function totalStock()
    {
        return $this->inventories->sum('quantity');
    }

    // cart img
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('img/default.jpeg');
        }

        return asset('storage/products/resized/' . $this->image);
    }

    // Relación con Tax
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }


}
