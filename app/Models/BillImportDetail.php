<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillImportDetail extends Model
{
    protected $table = 'bill_import_detail';

    protected $fillable = ["product_id", "bill_import_id", "supplier_id", "amount", "price", "entry_date", "expiry_date"];

    public function insertProductBill($request, $billId)
    {
        $data = [];
        foreach($request->product as $item) {
            $data[] = [            
                'product_id' => $item['product_id'],
                'bill_import_id' => $billId,
                'supplier_id' => $item['supplier_id'],
                'amount' => $item['amount'],
                'price' => $item['price'],
                'entry_date' => $item['entry_date'],
                'expiry_date' => $item['expiry_date'],  
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $this->insert($data);
    }
}
