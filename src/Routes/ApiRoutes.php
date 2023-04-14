<?php
namespace D3cr33\Payment\Routes;

use Illuminate\Contracts\Routing\Registrar as Router;
use D3cr33\Payment\Http\Controllers\PortController;

class ApiRoutes
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function all()
    {
        $this->port();
    }

    public function port()
    {
        $this->router->group(['prefix' => 'ports'], function($router){
            $router->get('', [PortController::class, 'getPorts']);
        });
    }
}
