<?php
namespace Modular\payment\Routes;

use Illuminate\Contracts\Routing\Registrar as Router;

class ApiRoutes
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function all()
    {
        $this->router->get('payment', function(){

        });
    }
}
