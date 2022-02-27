<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';

    protected $fillable = ["name", "type", "price", "date_from", "date_expiry", "description"];

    public function products() {
        return $this->hasMany(Product::class);
    } 
}
