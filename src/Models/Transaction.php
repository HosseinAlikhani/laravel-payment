<?php

namespace Modular\Payment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modular\Payment\Port\PortConfig;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public const STATUS_INIT = 1;
    public const STATUS_SUCCEED = 2;
    public const STATUS_FAILED = 3;

    /**
     * generate tracking code
     * @return string
     */
    public function generateTrackingCode(): string
    {
        return Str::random();
    }

    /**
     * get port namespace
     * @return string
     */
    public function getPortNamespace(): string
    {
        return PortConfig::getPortNamespace($this->port);
    }

    /**
     * gateway transaction has one relation
     */
    public function gatewayTransaction()
    {
        return $this->hasOne(GatewayTransaction::class, 'transaction_id', 'id');
    }
}
