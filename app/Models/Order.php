<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $with = ['car', 'driver', 'admin', 'company', 'destinations'];
    protected $fillable = [
        'admin_id',
        'driver_id',
        'company_id',
        'customer_id',
        'car_id',
        'destination',
        'status',
        'price',
        'number',
        'read_at',
        'date',
        'date_from',
        'date_to',
        'hours',
        'days',
        'note',
    ];
    protected $primaryKey = 'order_id';
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
    // public function destinations()
    // {
    //     return $this->belongsTo(Destination::class, 'destination');
    // }

    public function destinations()
    {
        return $this->belongsTo(DestinationPrice::class, 'destination');
    }
}
