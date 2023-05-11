<?php
namespace D3cr33\Payment\Test\Services;

use D3cr33\Payment\Services\PaymentService;
use D3cr33\Payment\Test\TestCase;

class PaymentServiceTest extends TestCase 
{
    public function test_payment_service_payment_method_validation()
    {
        $s = app(PaymentService::class);
        $s->payment([
            'user_id'   =>  $this->faker->uniqueId(),
            'model_type'   =>  $this->faker->modelType(),
            'model_id' =>  $this->faker->uniqueId(),
            'module'    =>  'management',
            'amount'    =>  $this->faker->amount(),
            'description'   =>  $this->faker->description(),
            'port'  =>  1
        ]);
    }
}
