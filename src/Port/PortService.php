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

    /**
     * is port valid
     * @param string $port
     * @return bool
     */
    public function isPortValid(string $port): bool
    {
        return key_exists( strtoupper($port) , $this->ports) ? true : false;
    }

    /**
     * get port namespace
     * @param string $port
     * @return string|bool
     */
    public function getPortNamespace(string $port): string|bool
    {
        if(! $this->isPortValid($port) ){
            return false;
        }

        $targetPort = $this->ports[strtoupper($port)];

        if(! isset($targetPort['NAMESPACE']) ){
            return false;
        }

        return $targetPort['NAMESPACE'];
    }
}
