<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table='employees';

    protected $fillable = ['name','phone','email','address','job','salary'];

    public function custodies(){

        return $this->hasMany(Custody::class,'employee_id');
    }

    public function discounts(){

        return $this->hasMany(Discount::class,'employee_id');
    }


    }
