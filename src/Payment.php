<?php
namespace Modular\Payment;

use Illuminate\Support\Facades\Route;
use Modular\Payment\Routes\ApiRoutes;
use Modular\Payment\Routes\WebRoutes;

final class Payment
{
    public static function ApiRoutes($callback = null, array $options = [])
    {
        $callback = $callback ?: function ($router) {
            $router->all();
        };
        $defaultOptions = [
            'middleware' => ['api'],
            'prefix'    =>  'api/payment',
        ];
        $options = array_merge($defaultOptions, $options);
        Route::group($options, function ($router) use ($callback) {
            $callback(new ApiRoutes($router));
        });
    }

    public static function WebRoutes($callback = null, array $options = [])
    {
        $callback = $callback ?: function ($router) {
            $router->all();
        };
        $defaultOptions = [
            'middleware' => [],
            'prefix'    =>  'payment',
        ];
        $options = array_merge($defaultOptions, $options);
        Route::group($options, function ($router) use ($callback) {
            $callback(new WebRoutes($router));
        });
    }
}
