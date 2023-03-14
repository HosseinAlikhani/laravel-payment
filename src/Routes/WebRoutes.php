<?php
namespace Modular\Payment\Routes;

use Illuminate\Contracts\Routing\Registrar as Router;
use Modular\Payment\Http\Controllers\PaymentController;

class WebRoutes
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function all()
    {
        $this->payment();
    }

    public function payment()
    {
        $this->router->get('callback', [PaymentController::class, 'getPaymentCallback']);
    }
}
