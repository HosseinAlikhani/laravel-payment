<?php
namespace D3cr33\Payment\Response;

use Exception;
use D3cr33\Payment\Exceptions\PortResponseException;

final class PortResponse
{
    /**
     * store status
     * @var bool
     */
    public bool $status;

    /**
     * store status code
     * @var int
     */
    public int $statusCode;

    /**
     * store message
     * @var string|null
     */
    public string|null $message;

    /**
     * store authority
     * @var string|null
     */
    public string|null $authority;

    /**
     * constructor of port response
     * @param array $response
     * @param bool $response[status]
     * @param int $response[status_code]
     * @param string $response[authority]
     */
    public function __construct(array $response)
    {
        $this->initialize($response);
    }

    /**
     * initialize port response
     * @param array $response
     * @return void
     */
    public function initialize(array $response): void
    {
        try{
            $this->status = $response['status'];
            $this->statusCode = $response['status_code'];
            $this->authority = $response['authority'];
            $this->message = $response['message'];
        }catch(Exception $e){
            throw new PortResponseException($e);
        }
    }
}
