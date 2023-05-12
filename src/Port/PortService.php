<?php
namespace D3cr33\Payment\Port;

final class PortService
{
    /**
     * payment ports
     * @var array|null
     */
    private array|null $ports = null;

    private static PortService|null $instance = null;

    public function __construct()
    {
        $config = config('payment');
        unset($config['ADDITIONAL']);
        $this->ports = $config;
    }

    /**
     * initialize port service
     * @return PortService
     */
    public static function initialize(): PortService
    {
        if(! self::$instance){
            self::$instance = new self();
        }

        return self::$instance;
    }


}
