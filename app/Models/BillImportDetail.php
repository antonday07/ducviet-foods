<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillImportDetail extends Model
{
    protected $table = 'bill_import_detail';

    protected $fillable = ["product_id", "bill_import_id", "entry_date", "expiry_date"];

    
}
