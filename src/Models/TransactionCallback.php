<?php

namespace D3cr33\Payment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionCallback extends Model
{
    use HasFactory;

    protected $table = 'payment_transaction_callbacks';
    protected $guarded = ['id'];

    protected $casts = [
        'callback_data' =>  'array'
    ];
}
