<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Shipping extends Authenticatable
{

    use HasApiTokens, Notifiable;

    protected $table = 'shippings';

    protected $fillable = ["name", "email", "password", "address"];

    // public function findAllEmployee($request)
    // {
    //     $data = $this->where('role', self::EMPLOYEE);
    //     if(!empty($request->search)) {
    //         $data->where('name', 'LIKE', '%' . $request->search . '%');
    //     }
    //     return $data->get();
    // }
}
