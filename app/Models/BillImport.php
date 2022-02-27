<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillImport extends Model
{
    protected $table = 'bill_import';

    protected $fillable = ["employee_id", "supplier_id", "date_import", "description", "note", "amount", "total_price", "status"];
}
