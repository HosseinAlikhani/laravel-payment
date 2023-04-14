<?php
namespace D3cr33\Payment\Repositories;

use D3cr33\Payment\Models\GatewayTransaction;
use D3cr33\Payment\Models\GatewayTransactionLog;

class GatewayTransactionRepository
{
    /**
     * find gateway transaction by ref id
     * @param string $refId
     * @return GatewayTransaction|null
     */
    public function findGatewayTransactionByRefId(string $refId): GatewayTransaction|null
    {
        return GatewayTransaction::where('ref_id', '=', $refId)->first();
    }

    /**
     * create transaction
     * @param array $gatewayTransactionData
     * @return GatewayTransaction|null
     */
    public function createGatewayTransaction(array $gatewayTransactionData): GatewayTransaction|null
    {
        $gatewayTransactionData['tracking_code'] = (new GatewayTransaction)->generateTrackingCode();
        $gatewayTransactionData['status'] = GatewayTransaction::STATUS_INIT;
        return GatewayTransaction::create($gatewayTransactionData);
    }

    /**
     * create gateway transaction log
     * @param int $gatewayTransactionId
     * @param array $logData
     * @return GatewayTransactionLog|null
     */
    public function createGatewayTransactionLog(int $gatewayTransactionId, array $logData): GatewayTransactionLog|null
    {
        $gatewayTransaction = GatewayTransaction::where('id', $gatewayTransactionId)
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
        GatewayTransaction::where('id', $gatewayTransactionId)->update($gatewayTransactionData);
    }
}
