<?php
namespace D3cr33\Payment\Test;

use D3cr33\Payment\PaymentServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * store payment faker
     * @var PaymentFaker
     */
    protected PaymentFaker $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = app(PaymentFaker::class);
        $this->artisan('migrate', ['--database' => 'sqlite'])->run();
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [PaymentServiceProvider::class];
    }
}
