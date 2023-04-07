<?php
namespace D3CR33\Payment\Repositories;

use Modular\Infrastructure\Base\BaseRepository;
use D3CR33\Payment\Models\Transaction;

class TransactionRepository extends BaseRepository
{
    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
    }

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

        return $this->findById($gatewayTransaction->transaction_id)
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
        $transactionData['tracking_code'] = $this->model->generateTrackingCode();
        $transactionData['status'] = Transaction::STATUS_INIT;
        $transaction = $this->create($transactionData);
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
        $transaction = $this->findById($transactionId)->first();
        if(! $transaction ){
            return false;
        }
        return $this->findById($transactionId)->update($transactionData);
    }
}
