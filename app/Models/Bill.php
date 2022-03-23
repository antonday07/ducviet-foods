<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    const ORDER_STATUS = 1 ;
    const SHIPPING_STATUS = 2;
    const SHIPPED_STATUS = 3;

    const PAID_STATUS = 1 ;
    const UNPAID_STATUS = 2;

    protected $table = 'bills';

    protected $fillable = ["user_id", "note", "code_bill", "date", "total_price", "delivery_address", "status", "status_payment", "bill_phone", "bill_email", "bill_name"];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function billDetails()
    {
        return $this->hasMany(BillDetail::class);
    }

    public function createBill($data)
    {
       return $this->create($data);
    }

    public function findAllBill($request)
    {
        $data = $this->with('user');
        if(!empty($request->search)) {
            $data->where('bill_name', 'LIKE', '%' . $request->search . '%');
        }      
        if(!empty($request->status_change) && $request->status_change != 5) {
            $data->where('status', $request->status_change);
        }
        return $data->get();
    }
}
