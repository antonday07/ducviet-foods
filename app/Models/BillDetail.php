<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    protected $table = 'bill_details';

    protected $fillable = [
        'bill_id','product_id','amount','price'
    ];

    public function bill() {
        return $this->belongsTo(Bill::class);
    }
    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function insertBillDetail(array $products, int $id)
    {
        $data = [];
        $total = 0;
    
        foreach($products as $key => $item) {          
            $data[] = [
                'bill_id' => $id,
                'product_id' => $key,
                'amount' => $item['quantity'],
                'price' => $item['price'],         
                'created_at' => now(),
                'updated_at' => now()       
            ];
            $total += $item['price'] * $item['quantity'];
        }
        $this->insert($data);
        return $total;
    }
}
