<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customers()
    {
        return $this->belongsTo(User::class, 'customer');
    }
    public function details()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }
}
