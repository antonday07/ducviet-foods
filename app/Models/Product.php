<?php

namespace App\Models;

use App\Libraries\Ultilities;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = ["unit_id", "category_id", "promotion_id", "supplier_id", "name", "slug", "entry_price", "retail_price", "description", "status", "image"];
    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function billDetails()
    {
        return $this->hasMany(BillDetail::class);
    }
    /** attribute here */

    public function getImageAttribute($value)
    {
        return Ultilities::replaceUrlImage($value);
    }

    public function getPriceDiscountAttribute()
    {
        $price = $this->promotion->price;
        if($this->promotion->type == 1) {
            return $this->retail_price - $price;
        } else {
            return $this->retail_price - $this->retail_price * ($price / 100);
        }
    }

}
