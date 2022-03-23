<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillImport extends Model
{
    protected $table = 'bill_import';

    protected $fillable = ["employee_id", "code_bill", "date_import", "description", "note", "total_price", "status"];


    public function employee()
    {
        return $this->belongsTo(Admin::class, 'employee_id');
    }

    public function productBills()
    {
        return $this->hasMany(BillImportDetail::class, 'bill_import_id', 'id');
    }

    public function calTotalPrice(array $data)
    {
        $totalPrice = 0;
     
        foreach($data as $item) {
            $totalPrice += $item['price'];
        }
        return $totalPrice;
    }

    public function insertBillImport($data) 
    {
        return $this->create($data);
    }

    public function getAllBills($request)
    {
        $data = $this->with('employee', 'productBills.product.unit', 'productBills.supplier');
        if(!empty($request->search)) {
            $data->where('code_bill', 'LIKE', '%' . $request->search . '%');
        }      
        return $data->get();
    }
}
