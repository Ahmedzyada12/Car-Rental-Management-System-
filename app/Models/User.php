<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'role',
        'driver_price',
        'parent_id',
        'password',
        'phone',
        'address',
        'city',
        'country',
        'vendor_id',

    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $primaryKey = 'user_id';
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function order_vendor()
    {
        return $this->hasMany(Order::class, 'company_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id')->withDefault([
            'first_name' => "-"
        ]);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'customer');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class, 'driver_id');
    }


    public function drivers()
    {
        return $this->hasMany(User::class, 'vendor_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class,'vendor_id','user_id');
    }

}
