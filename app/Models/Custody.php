<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Custody extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='custodies';

    protected $fillable=['employee_id','amount','residual_custody','notes'];

public function employees(){

    return $this->belongsTo(Employee::class,'employee_id');
}
}
