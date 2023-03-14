<?php
namespace D3CR33\Payment\Repositories;

use Modular\Infrastructure\Base\BaseRepository;
use D3CR33\Payment\Models\GatewayTransaction;
use D3CR33\Payment\Models\GatewayTransactionLog;

class GatewayTransactionRepository extends BaseRepository
{
    public function __construct(GatewayTransaction $gatewayTransaction)
    {
        parent::__construct($gatewayTransaction);
    }

    /**
     * find gateway transaction by ref id
     * @param string $refId
     * @return GatewayTransaction|null
     */
    public function findGatewayTransactionByRefId(string $refId): GatewayTransaction|null
    {
        return $this->where('ref_id', '=', $refId)->first();
    }

    /**
     * create transaction
     * @param array $gatewayTransactionData
     * @return GatewayTransaction|null
     */
    public function createGatewayTransaction(array $gatewayTransactionData): GatewayTransaction|null
    {
        $gatewayTransactionData['tracking_code'] = $this->model->generateTrackingCode();
        $gatewayTransactionData['status'] = GatewayTransaction::STATUS_INIT;
        return $this->create($gatewayTransactionData);
    }

    /**
     * create gateway transaction log
     * @param int $gatewayTransactionId
     * @param array $logData
     * @return GatewayTransactionLog|null
     */
    public function createGatewayTransactionLog(int $gatewayTransactionId, array $logData): GatewayTransactionLog|null
    {
        $gatewayTransaction = $this->findById($gatewayTransactionId)
            ->first();

        if (! $gatewayTransaction ){
            return null;
        }
        return $gatewayTransaction->logs()
            ->create($logData);
    }

    /**
     * update gateway transaction
     * @param int $transactionId
     * @param array $gatewayTransactionData
     */
    public function updateGatewayTransaction(int $gatewayTransactionId, array $gatewayTransactionData)
    {
        $this->findById($gatewayTransactionId)->update($gatewayTransactionData);
    }
}
