<?php
namespace D3cr33\Payment\Http\Controllers;

use Illuminate\Http\Request;
use D3cr33\Payment\Port\PortConfig;

class PortController
{
    /**
     * store request
     * @var Request
     */
    private Request $request;

    /**
     * @var Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * get payment ports
     * @method GET
     * @link /payment/ports
     */
    public function getPorts()
    {
        return [
            [
                'id'    =>  strtoupper(current(PortConfig::AVAILABLE_PORT)),
                'name'  =>  current(PortConfig::AVAILABLE_PORT),
                'fa_name'   =>  'زرین پال',
                'icon_url'  =>  url('storage/port/zarinpal.png')
            ]
        ];
    }
}
