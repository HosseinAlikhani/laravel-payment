<?php

namespace Modular\Payment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatewayTransactionLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const UPDATED_AT = null;
}
