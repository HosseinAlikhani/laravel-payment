<?php
namespace D3cr33\Payment\HttpService;

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
    private int $timeout;

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
     * set service timeout
     * @param int $timeout
     * @return SoapClientService
     */
    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;
        return $this;
    }
}