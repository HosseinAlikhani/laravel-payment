<?php

namespace D3cr33\Payment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use D3cr33\Payment\Port\PortConfig;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payment_transactions';
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
    public function portNamespace(): string
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

    /**
     * transaction callback relation
     */
    public function callback()
    {
        return $this->hasOne(TransactionCallback::class, 'transaction_id', 'id');
    }

    /**
     * dispatch transaction callback
     */
    public function dispatchCallback()
    {
        $callback = $this->callback;
        if (! $callback) {
            return true;
        }

        $callback->callback::dispatch($callback->callback_data);
        $callback->update([
            'is_callback_send'  =>  true
        ]);
        return true;
    }
}
