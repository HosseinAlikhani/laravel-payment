<?php
namespace D3cr33\Payment\Test\Services;

use D3cr33\Payment\HttpService\SoapClientService;
use D3cr33\Payment\Services\PaymentService;
use D3cr33\Payment\Test\TestCase;
use Mockery\MockInterface;

class PaymentServiceTest extends TestCase 
{
    public function test_payment_service_payment_method_validation()
    {
        $service = app(PaymentService::class);
        $result = $service->payment([
            'user_id'   =>  $this->faker->uniqueId(),
            'model_type'   =>  $this->faker->modelType(),
            'model_id' =>  $this->faker->uniqueId(),
            'module'    =>  'management',
            'amount'    =>  $this->faker->amount(),
            'description'   =>  $this->faker->description(),
            'port'  =>  $this->faker->port()
        ]);

        $this->assertEquals(true, $result['status']);
        $this->assertArrayHasKey('url', $result);
    }

    /**
     * test payment service payment callback success
     */
    public function test_payment_service_payment_callback_failed()
    {
        $service = app(PaymentService::class);

        $resultPayment = $service->payment([
            'user_id'   =>  $this->faker->uniqueId(),
            'model_type'   =>  $this->faker->modelType(),
            'model_id' =>  $this->faker->uniqueId(),
            'module'    =>  'management',
            'amount'    =>  $this->faker->amount(),
            'description'   =>  $this->faker->description(),
            'port'  =>  $this->faker->port()
        ]);

        $result = $service->paymentCallback([
            'Authority' =>  $resultPayment['authority'],
            'Status'    =>  'OK'
        ]);

        $this->assertEquals(false, $result['status']);
    }
}
