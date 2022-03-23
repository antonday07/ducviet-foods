<?php

namespace App\Models;

use App\Libraries\Ultilities;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'image', 'email', 'password', 'phone', 'address', 'dob'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** attribute here */

    public function getAvatarAttribute($value)
    {
        return Ultilities::replaceUrlImage($value);
    }
    public function bills() {
        return $this->hasMany(Bill::class);
    }

    public function updateInfoUser(array $data, int $id)
    {
        return $this->where($this->primaryKey, $id)->update($data);
    }

    public function getDetailById(int $id)
    {
        return $this->with('bills')
                    ->where($this->primaryKey, $id)
                    ->first();
    }

    public function findAllCustomer($request)
    {
        $data = $this->query();
        if(!empty($request->search)) {
            $data->where('name', 'LIKE', '%' . $request->search . '%');
        }
        return $data->get();
    }
}
