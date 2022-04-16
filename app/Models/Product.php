<?php

namespace App\Models;

use App\Libraries\Ultilities;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Product extends Model
{
    protected $table = 'products';

    const SELLING = 1 ;
    const PAUSE_SELLING = 2;
    const OUT_OF_STOCK = 3;

    protected $fillable = ["unit_id", "category_id", "promotion_id", "supplier_id", "name", "slug", "entry_price", "retail_price", "description", "status", "image"];
    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
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

    public function billProductsDetail()
    {
        return $this->hasMany(BillImportDetail::class, 'product_id', 'id');
    }

    public function warehouse()
    {
        return $this->hasOne(Warehouse::class, 'product_id', 'id');
    }
    /** attribute here */

    public function getImageAttribute($value)
    {
        return Ultilities::replaceUrlImage($value);
    }

    public function getIsOutOfStockAttribute()
    {
        if($this->status == self::OUT_OF_STOCK ) {
            return 'sold';
        }

        if(!empty($this->warehouse)) {
            if($this->warehouse->quantity < 1) {
                return 'sold';
            }
        }
        return 'in';
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

    public function getListProduct($request)
    {
        $data = $this->with('unit', 'billProductsDetail', 'billDetails');
        if(!empty($request->search)) {
            $data->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if(!empty($request->month) && !empty($request->year)) {
            
            $data->whereHas('billDetails', function($query) use ($request) { 
                $query->whereMonth('created_at', $request->month)
                     ->whereYear('created_at', $request->year);
            })->orWhereHas('billProductsDetail', function($query) use ($request) {
                $query->whereMonth('created_at', $request->month)
                ->whereYear('created_at', $request->year);
            });
        }  

        return $data->get();
    }

}
