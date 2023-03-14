<?php
namespace Modular\Payment\Port;

use Exception;
use Modular\Payment\Exceptions\PortGatewayException;
use Modular\Payment\Exceptions\ZarinpalException;
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
            $client = new SoapClient($this->portConfig->send, [
                'encoding' => 'UTF-8',
                'connection_timeout'    =>  10
            ]);

            $this->setResponse($client->PaymentRequest([
                'MerchantID'     => $this->portConfig->apiKey,
                'Amount'         => $this->amount,
                'Description'    => 'zarinpal gateway',
                'Email'          => null,
                'Mobile'         => null,
                'CallbackURL'    => $this->portConfig->callbackUrl,
            ]));

            if ( $this->portResponse->status ) {
                $this->setRefToGatewayTransaction();

                return [
                    'status'    =>  true,
                    'url'   => $this->portConfig->gate.$this->portResponse->authority
                ];
            }

        }catch(Exception $e){
            throw new PortGatewayException($e);
        }

        $this->createLog();
        throw new ZarinpalException($this->portResponse->statusCode);
    }

    /**
     * verify payment
     */
    public function verify(array $verifyData)
    {
        if ( isset($verifyData['Status']) && $verifyData['Status'] === 'NOK'){
            return [
                'status'    =>  false,
                'message'   =>  'درخواست شما کنسل شده است.'
            ];
        }

        try {
            $client = new SoapClient($this->portConfig->send, [
                'encoding' => 'UTF-8',
                'connection_timeout'    =>  10
            ]);

            $this->setResponse($client->PaymentVerification([
                'MerchantID'     => $this->portConfig->apiKey,
                'Authority' => $verifyData['Authority'],
                'Amount' => 1200
            ]));

            if( $this->portResponse->status ) {
                $this->paymentSucceed();
            } else {
                $this->paymentFailed();
                $this->createLog();
            }
        }catch(Exception $e){

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
            'status_code'   =>  isset($result->Status) ? $result->Status : null,
            'message'   =>  isset($result->Status) ? ZarinpalException::getMessageFromStatusCode($result->Status) : null,
            'authority' => isset($result->Authority) && $result->Authority != "" ? $result->Authority : null
        ]);
    }
}
