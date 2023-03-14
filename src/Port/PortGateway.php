<?php
namespace D3CR33\Payment\Port;

use D3CR33\Payment\Models\GatewayTransaction;
use D3CR33\Payment\Models\Transaction;
use D3CR33\Payment\Repositories\GatewayTransactionRepository;
use D3CR33\Payment\Repositories\TransactionRepository;
use D3CR33\Payment\Response\PortResponse;

abstract class PortGateway
{
    /**
     * store gateway transaction
     * @var GatewayTransaction
     */
    protected GatewayTransaction $gatewayTransaction;

    /**
     * store transaction
     * @var Transaction
     */
    protected Transaction $transaction;

    /**
     * store amount
     * @var int
     */
    protected int $amount;

    /**
     * store port config
     * @var PortConfig
     */
    protected PortConfig $portConfig;

    /**
     * store port response
     * @var PortResponse
     */
    protected PortResponse $portResponse;

    /**
     * store gateway transaction repository
     * @var GatewayTransactionRepository
     */
    private GatewayTransactionRepository $gatewayTransactionRepository;

    /**
     * store transaction repository
     * @var TransactionRepository
     */
    private TransactionRepository $transactionRepository;

    /**
     * constructor of port gateway
     * @param GatewayTransactionRepository $gatewayTransactionRepository
     */
    public function __construct(
        GatewayTransactionRepository $gatewayTransactionRepository,
        TransactionRepository $transactionRepository
    )
    {
        $this->transactionRepository = $transactionRepository;
        $this->gatewayTransactionRepository = $gatewayTransactionRepository;
    }

    /**
     * initialize port
     * @param Transaction $transaction
     * @return self
     */
    public function initialize(Transaction $transaction, GatewayTransaction|null $gatewayTransaction = null): self
    {
        $this->setTransaction($transaction);
        if ( $gatewayTransaction ) $this->setGatewayTransaction($gatewayTransaction);
        $this->amount = $transaction->amount;
        $this->portConfig = $this->setConfig();
        return $this;
    }

    /**
     * set transaction
     * @param Transaction $transaction
     * @return self
     */
    public function setTransaction(Transaction $transaction): self
    {
        $this->transaction = $transaction;
        return $this;
    }

    /**
     * set gateway transaction
     * @param GatewayTransaction $gatewayTransaction
     * @return self
     */
    public function setGatewayTransaction(GatewayTransaction $gatewayTransaction): self
    {
        $this->gatewayTransaction = $gatewayTransaction;
        return $this;
    }

    /**
     * create gateway transaction
     * @return self
     */
    public function createGatewayTransaction(): self
    {
        return $this->setGatewayTransaction($this->gatewayTransactionRepository->createGatewayTransaction([
            'transaction_id'    =>  $this->transaction->id,
            'port'  =>  $this->transaction->port,
            'amount'    =>  $this->transaction->amount,
            'description'   =>  $this->transaction->description
        ]));
    }

    /**
     * create gateway transaction log
     */
    protected function createLog()
    {
        return $this->gatewayTransactionRepository->createGatewayTransactionLog($this->gatewayTransaction->id,[
            'result_status' =>  $this->portResponse->statusCode,
            'result_message'    =>  $this->portResponse->message
        ]);
    }

    /**
     * payment succeed
     * @return void
     */
    public function paymentSucceed(): void
    {
        $this->transactionRepository->updateTransaction($this->transaction->id, [
            'status'    =>  Transaction::STATUS_SUCCEED
        ]);

        $this->gatewayTransactionRepository->updateGatewayTransaction($this->gatewayTransaction->id,[
            'status'    =>  GatewayTransaction::STATUS_SUCCEED,
            'payment_at'    =>  now()
        ]);
    }

    /**
     * payment failed
     * @return void
     */
    public function paymentFailed(): void
    {
        $this->transactionRepository->updateTransaction($this->transaction->id, [
            'status'    =>  Transaction::STATUS_FAILED
        ]);

        $this->gatewayTransactionRepository->updateGatewayTransaction($this->gatewayTransaction->id,[
            'status'    =>  GatewayTransaction::STATUS_FAILED,
        ]);
    }

    /**
     * set ref to gateway transaction
     */
    protected function setRefToGatewayTransaction()
    {
        $this->gatewayTransactionRepository
            ->updateGatewayTransaction($this->gatewayTransaction->id,[
                'ref_id'    =>  $this->portResponse->authority
            ]);
    }

    /**
     * initialize port response
     * @param array $portResponse
     * @return void
     */
    protected function initializePortResponse(array $portResponse): void
    {

        $this->portResponse = new PortResponse([
            'status'    =>  $portResponse['status'] ?? null,
            'status_code'   =>  $portResponse['status_code'] ?? null,
            'authority' =>  $portResponse['authority'] ?? null,
            'message'   =>  $portResponse['message'] ?? null
        ]);
    }

    /**
     * abstract method for set config from port
     * @return PortConfig
     */
    abstract protected function setConfig(): PortConfig;
}
