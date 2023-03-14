<?php
namespace D3CR33\Payment\Http\Controllers;

use Illuminate\Http\Request;
use Modular\Infrastructure\Base\BaseController;
use D3CR33\Payment\Services\PaymentService;

class PaymentController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getPaymentCallback()
    {
        $response = app(PaymentService::class)->paymentCallback($this->request->all());
        dd( $response );
    }
}
