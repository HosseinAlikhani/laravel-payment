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
}