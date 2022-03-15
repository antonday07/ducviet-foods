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

    protected $fillable = ["user_id", "note", "date", "total_price", "delivery_address", "status", "status_payment"];
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
            $data->whereHas('user', function($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            });        
        }      
        if(!empty($request->status)) {
            $data->where('status', $request->status);
        }
        return $data->get();
    }
}
