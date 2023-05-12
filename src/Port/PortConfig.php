<?php
namespace D3cr33\Payment\Port;

use Exception;
use D3cr33\Payment\Exceptions\PortConfigException;

final class PortConfig
{
    public const AVAILABLE_PORT = [
        1   =>  'zarinpal'
    ];

    /**
     * store api key
     * @var string
     */
    public string $apiKey;

    /**
     * store send url
     * @var string
     */
    public string $send;

    /**
     * store gate url
     * @var string
     */
    public string $gate;

    /**
     * store callback url
     * @var string
     */
    public string $callbackUrl;

    /**
     * port config constructor
     * @param string $port
     */
    public function __construct(string $port)
    {
        $this->initialize($port);
    }

    /**
     * initialize port config + set property
     * @param string $port
     * @return void
     */
    public function initialize(string $port): void
    {
        try{
            $config = config('payment.'.strtoupper($port));
            $this->apiKey = $config['API_KEY'];
            $this->callbackUrl = $config['PAYMENT_CALLBACK'] ?? config('payment.ADDITIONAL.PAYMENT_CALLBACK');
            if ( isset($config['IS_TEST']) ) {
                $this->send = $config['TEST_SEND'];
                $this->gate = $config['TEST_GATE'];
            }else {
                $this->send = $config['SEND'];
                $this->gate = $config['GATE'];
            }
        }catch(Exception $e){
            throw new PortConfigException($e);
        }
    }

    /**
     * return port namespace
     * @param int $port
     * @return string
     */
    public static function getPortNamespace(int $port): string
    {
        return PortService::initialize()->getPortNamespace($port);
    }
}
