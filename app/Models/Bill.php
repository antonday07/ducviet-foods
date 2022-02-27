<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';

    protected $fillable = ["id", "Name", "Phone", "Address", "Email", "Status", "total"];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function billDetails()
    {
        return $this->hasMany(BillDetail::class);
    }
}
