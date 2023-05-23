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
     * @return self
     */
    public function setUrl(string $url):self
    {
        $this->url = $url;
        return $this;
    }
}