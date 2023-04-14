<?php

namespace D3cr33\Payment;

use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/payment.php', 'payment');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishing();
        $this->loadRequirements();

        Payment::ApiRoutes();
        Payment::WebRoutes();
    }


    /**
     * load requirements section
     */
    private function loadRequirements()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->loadTranslationsFrom(__DIR__.'/../Lang', 'payment');
    }

    /**
     * register publishing file
     */
    private function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/../Config/payment.php' => config_path('payment.php'),
        ], 'payment-config');
    }
}
