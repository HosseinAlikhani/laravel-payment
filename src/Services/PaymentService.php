<?php
namespace Modular\Payment\Services;

use Illuminate\Http\Response;
use Modular\Payment\Repositories\TransactionRepository;
use Modular\Payment\Requests\PaymentRequest;

final class PaymentService
{
    /**
     * store transaction repository
     */
    private TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * payment
     * @param array $paymentData
     * @param int $paymentData[user_id]
     * @param string $paymentData[module_type]
     * @param int $paymentData[module_id]
     * @param string $paymentData[module]
     * @param int $paymentData[amount]
     * @param string $paymentData[description]
     * @param int $paymentData[port]
     */
    public function payment(array $paymentData)
    {
        $paymentRequest = new PaymentRequest($paymentData);

        $transaction = $this->transactionRepository->createTransaction($paymentRequest->toArray());

        return app($transaction->getPortNamespace())
            ->initialize($transaction)
            ->createGatewayTransaction()
            ->send();
    }

    /**
     * payment callbacl
     * @param array $callbackData
     */
    public function paymentCallback(array $callbackData)
    {
        $transaction = $this->transactionRepository->findTransactionByGatewayTransactionRefId($callbackData['Authority']);
        if(! $transaction ) {
            return [
                'status'    =>  Response::HTTP_UNPROCESSABLE_ENTITY,
                'message'   =>  'not found'
            ];
        }

        return app($transaction->getPortNamespace())
            ->initialize($transaction, $transaction->gatewayTransaction)
            ->verify($callbackData);
    }
}
