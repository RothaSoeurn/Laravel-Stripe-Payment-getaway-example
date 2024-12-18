<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'payment_id',
        'product_name',
        'quantity',
        'amount',
        'currency',
        'customer_name',
        'customer_email',
        'payment_status',
        'payment_methods',
    ];
}
