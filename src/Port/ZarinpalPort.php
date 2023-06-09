<?php
namespace D3cr33\Payment\Port;

use Exception;
use D3cr33\Payment\Exceptions\ZarinpalException;
use D3cr33\Payment\HttpService\SoapClientService;
use D3cr33\Payment\Models\GatewayTransaction;
use SoapClient;

class ZarinpalPort extends PortGateway
{
    /**
     * abstract method for set config from port
     * @return PortConfig
     */
    protected function setConfig(): PortConfig
    {
        return new PortConfig('zarinpal');
    }

    /**
     * abstract method for send
     */
    public function send()
    {
        try {
            $soapClientService = app(SoapClientService::class);
            $this->setResponse(
                $soapClientService
                    ->setUrl($this->portConfig->send)
                    ->paymentRequest([
                        'MerchantID'     => $this->portConfig->apiKey,
                        'Amount'         => $this->amount,
                        'Description'    => 'zarinpal gateway',
                        'Email'          => null,
                        'Mobile'         => null,
                        'CallbackURL'    => $this->portConfig->callbackUrl,
                    ])
            );

            if ( $this->portResponse->status ) {
                $this->setRefToGatewayTransaction();

                return [
                    'status'    =>  true,
                    'url'   => $this->portConfig->gate.$this->portResponse->authority,
                    'authority' =>  $this->portResponse->authority
                ];
            }

        }catch(Exception $e){
            $this->setResponse((object)[
                'Message'   =>  $e->getMessage(),
                'Status'    =>  500
            ]);
        }

        $this->createLog();
        throw new ZarinpalException($this->portResponse->statusCode);
    }

    /**
     * verify payment
     */
    public function verify(array $verifyData)
    {
        if ( $this->gatewayTransaction->status != GatewayTransaction::STATUS_INIT ) {
            return [
                'status'    =>  false,
                'message'   =>  trans('payment::messages.payment_submited_before')
            ];
        }

        if ( isset($verifyData['Status']) && $verifyData['Status'] === 'NOK'){
            $this->paymentFailed();
            return [
                'status'    =>  false,
                'message'   =>  trans('payment::messages.payment_canceld')
            ];
        }

        try {
            $soapClientService = app(SoapClientService::class);
            $this->setResponse(
                $r = $soapClientService
                    ->setUrl($this->portConfig->send)
                    ->paymentVerification([
                        'MerchantID'     => $this->portConfig->apiKey,
                        'Authority' => $verifyData['Authority'],
                        'Amount' => $this->amount
                    ])
            );

            if( $this->portResponse->status ) {
                $this->paymentSucceed();
                return [
                    'status'    =>  true,
                    'message'   =>  trans('payment::messages.payment_succeed'),
                    'data'  =>  $this->getTransactionCallbackData()
                ];
            } else {
                $this->paymentFailed();
                $this->createLog();
                return [
                    'status'    =>  false,
                    'message'   =>  ZarinpalException::getMessageFromStatusCode($this->portResponse->statusCode)
                ];
            }
        }catch(Exception $e){
            $this->setResponse((object)[
                'Message'   =>  $e->getMessage()
            ]);
            $this->paymentFailed();
            $this->createLog();
        }
    }

    /**
     * translate port response
     * @param $result
     * @return void
     */
    private function setResponse($result): void
    {
        $this->initializePortResponse([
            'status'    =>  isset($result->Status) && ($result->Status == 100 || $result->Status == 101) ? true : false,
            'status_code'   =>  isset($result->Status) ? $result->Status : 500,
            'message'   =>  isset($result->Status) ? ZarinpalException::getMessageFromStatusCode($result->Status) : $result->Message ?? null,
            'authority' => isset($result->Authority) && $result->Authority != "" ? $result->Authority : null
        ]);
    }
}
