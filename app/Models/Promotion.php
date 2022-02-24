<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';

    protected $fillable = ["id", "name", "description", "percent"];

    public function products() {
        return $this->hasMany(Product::class);
    } 
}
