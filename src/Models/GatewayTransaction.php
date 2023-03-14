<?php

namespace D3CR33\Payment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class GatewayTransaction extends Model
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
     * add logs relation has many
     */
    public function logs()
    {
        return $this->hasMany(GatewayTransactionLog::class, 'gateway_transaction_id', 'id');
    }

    /**
     * transaction relation has one
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }
}
