<?php

namespace D3cr33\Payment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatewayTransactionLog extends Model
{
    use HasFactory;

    protected $table = 'payment_gateway_transaction_logs';
    protected $guarded = ['id'];

    const UPDATED_AT = null;
}
