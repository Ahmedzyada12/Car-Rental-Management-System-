<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category_id',
        'hourlyprice',
        'dailyprice',
    ];
    protected $primaryKey = 'car_id';
    protected $with = ['category'];
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function orders()
    {
        return  $this->hasMany(Order::class);
    }
}
