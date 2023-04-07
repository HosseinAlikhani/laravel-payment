<?php

namespace D3CR33\Payment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionCallback extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'callback_data' =>  'array'
    ];
}
