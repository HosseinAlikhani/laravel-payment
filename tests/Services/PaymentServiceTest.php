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
        $this->mock(SoapClientService::class, function(MockInterface $mock){
            $mock->shouldReceive('setUrl')
                ->andReturnSelf()
                ->shouldReceive('paymentRequest')
                ->andReturn((object)[
                    'Status'    =>  100,
                    'Authority' =>  $this->faker->authority()
                ]);
        });

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
    public function test_payment_service_payment_callback_succeed()
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

        $this->mock(SoapClientService::class, function(MockInterface $mock){
            $mock->shouldReceive('setUrl')
                ->andReturnSelf()
                ->shouldReceive('paymentVerification')
                ->andReturn((object)[
                    'Status'    =>  100,
                    'Authority' =>  $this->faker->authority()
                ]);
        });

        $result = $service->paymentCallback([
            'Authority' =>  $resultPayment['authority'],
            'Status'    =>  'OK'
        ]);

        $this->assertEquals(true, $result['status']);
        $this->assertEquals(trans('payment::messages.payment_succeed'), $result['message']);
    }

    /**
     * test payment callback with raised not found transaction error
     */
    public function test_payment_service_payment_callback_transaction_not_found()
    {
        $service = app(PaymentService::class);
        $result = $service->paymentCallback([
            'Authority' =>  $this->faker->authority(),
            'Status'    =>  'OK'
        ]);

        $this->assertEquals(422, $result['status']);
        $this->assertEquals(trans('payment::messages.transaction_not_found'), $result['message']);

    }
}
