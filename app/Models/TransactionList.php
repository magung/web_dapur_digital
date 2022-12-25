<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionList extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'transaction_type_id',
        'transaction_status_id',
        'payment_method_id',
        'payment_status_id',
        'user_id',
        'final_price',
        'created_by',
        'updated_by',
        'file'
    ];
}
