<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'driver_id',
    ];
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
