<?php
namespace D3cr33\Payment\Repositories;

use D3cr33\Payment\Models\Transaction;

class TransactionRepository
{
    /**
     * find gateway transaction by ref id
     * @param string $refId
     * @return Transaction|null
     */
    public function findTransactionByGatewayTransactionRefId(string $refId): Transaction|null
    {
        $gatewayTransaction = app(GatewayTransactionRepository::class)->findGatewayTransactionByRefId($refId);
        if(! $gatewayTransaction ) {
            return null;
        }

        return Transaction::where('id', $gatewayTransaction->transaction_id)
            ->with(['gatewayTransaction'])
            ->first();
    }

    /**
     * create transaction
     * @param array $transactionData
     * @return Transaction|null
     */
    public function createTransaction(array $transactionData): Transaction|null
    {
        $transactionData['tracking_code'] = (new Transaction())->generateTrackingCode();
        $transactionData['status'] = Transaction::STATUS_INIT;
        $transaction = Transaction::create($transactionData);
        if ( isset($transactionData['callback']) && isset($transactionData['callback_data']) ){
            $transaction->callback()->create([
                'callback'  =>  $transactionData['callback'],
                'callback_data' =>  $transactionData['callback_data']
            ]);
        }
        return $transaction;
    }

    /**
     * update transaction
     * @param int $transactionId
     * @param array $transactionData
     * @return bool
     */
    public function updateTransaction(int $transactionId, array $transactionData): bool
    {
        $transaction = Transaction::where('id', $transactionId)->first();
        if(! $transaction ){
            return false;
        }
        return $transaction->update($transactionData);
    }
}
