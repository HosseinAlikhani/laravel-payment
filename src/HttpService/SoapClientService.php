<?php
namespace D3cr33\Payment\HttpService;

use SoapClient;

final class SoapClientService
{
    /**
     * store soap client service instance
     * @var SoapClientService
     */
    private static $instance;

    /**
     * store client url
     * @var string
     */
    private string $url;

    /**
     * store service timeout
     */
    private int $timeout = 10;

    /**
     * store service encoding
     * @param string
     */
    private string $encoding = 'UTF-8';

    /**
     * initialize soap client service
     * @return SoapClientService
     */
    public static function initialize(): self
    {
        if(! self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * set url for client
     * @param string $url
     * @return SoapClientService
     */
    public function setUrl(string $url):self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * set service encoding
     * @param string $encoding
     * @return SoapClientService
     */
    public function setEncoding(string $encoding): self
    {
        $this->encoding = $encoding;
        return $this;
    }

    /**
     * set service timeout
     * @param int $timeout
     * @return SoapClientService
     */
    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * fire payment request
     * @param array $data
     */
    public function paymentRequest(array $data)
    {
        return $this->client()->PaymentRequest($data);
    }

    /**
     * initialize client instance
     * @return SoapClient
     */
    private function client(): SoapClient
    {
        return new SoapClient($this->url, [
            'encoding' => $this->encoding,
            'connection_timeout'    =>  $this->timeout
        ]);
    }
}