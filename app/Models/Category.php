<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table="categories";
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'name',
        'hourlyprice',
        'dailyprice',
        'vendor_id'


    ];
    public function cars()
    {
        return $this->hasMany(Car::class,'category_id');
    }



}
