<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouse';

    protected $fillable = ["product_id", "month", "year", "sum_import", "quantity"];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function findByProductId(int $productId)
    {
        return $this->where('product_id', $productId)->first();
    }

    public function updateWarehouse(int $productId, int $quantity)
    {
        return $this->updateOrCreate(
            ['product_id' => $productId],
            ['quantity' => $quantity]
        );
    }

    public function getListProductWarehouse($request)
    {
        $data = $this->with('product');
        
        if(!empty($request->product)) {
            $data->whereHas('product', function($query) use($request) {
                $query->where('id', $request->product);   
            });
        }

        return $data->get();
    }
}
