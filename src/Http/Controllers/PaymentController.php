<?php
namespace D3CR33\Payment\Http\Controllers;

use Illuminate\Http\Request;
use D3CR33\Payment\Services\PaymentService;

class PaymentController
{
    /**
     * store request
     * @var Request
     */
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * payment callback action
     * @method GET
     * @link payment/callback
     */
    public function getPaymentCallback()
    {
        $response = app(PaymentService::class)->paymentCallback($this->request->all());
        //TODO must set payment view
        return view('payment', compact('response'));
    }
}
