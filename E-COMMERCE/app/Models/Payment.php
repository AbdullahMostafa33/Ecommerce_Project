<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'invoice_id',
        'payment_reference',
        'InvoiceStatus',
        'payment_gateway',
        'transaction_id',
        'authorization_id',
        'transaction_status',
        'transaction_value',
        'currency',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
