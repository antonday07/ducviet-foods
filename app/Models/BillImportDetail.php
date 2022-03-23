<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillImportDetail extends Model
{
    protected $table = 'bill_import_detail';

    protected $fillable = ["product_id", "bill_import_id", "supplier_id", "amount", "price","total_price" ,"entry_date", "expiry_date"];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function billImport()
    {
        return $this->belongsTo(BillImport::class, 'bill_import_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function insertProductBill($request, int $billId, object $warehouse)
    {
        $data = [];
        foreach($request->product as $item) {
            $data[] = [            
                'product_id' => $item['product_id'],
                'bill_import_id' => $billId,
                'supplier_id' => $item['supplier_id'],
                'amount' => $item['amount'],
                'price' => $item['price'],              
                'total_price' => $item['price'] * $item['amount'],
                'entry_date' => $item['entry_date'],
                'expiry_date' => $item['expiry_date'],  
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $product = $warehouse->findByProductId($item['product_id']);
            
            $quantity = !empty($product) ? $product->quantity + $item['amount'] : $item['amount'];

            $warehouse->updateWarehouse($item['product_id'], $quantity);
        }

        return $this->insert($data);
    }

    public function getListProductImport($request)
    {
        $data = $this->with('product', 'supplier');
        if(!empty($request->product)) {
            $data->whereHas('product', function($query) use($request) {
                $query->where('id', $request->product);   
            });
        }

        
        if(!empty($request->supplier)) {
            $data->whereHas('supplier', function($query) use($request) {
                $query->where('id', $request->supplier);   
            });
        }

        return $data->get();
    }
}
