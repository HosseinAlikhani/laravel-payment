<?php

use D3cr33\Payment\Port\ZarinpalPort;

return [

    'ZARINPAL' => [
        'ACTIVE'    =>  true,
        'NAMESPACE' =>  ZarinpalPort::class,
        'ICON_URL'  =>  url('storage/port/zarinpal.png'),
        'FA_NAME'   =>  'زرین پال',
        'IS_TEST' => true,

        'API_KEY'  =>  '1122334455667788998811223344556677',

        'SEND' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',
        'GATE'  =>  'https://www.zarinpal.com/pg/StartPay/',

        'TEST_SEND'   =>  'https://sandbox.zarinpal.com/pg/services/WebGate/wsdl',
        'TEST_GATE' =>  'https://sandbox.zarinpal.com/pg/StartPay/',
    ],

    'ADDITIONAL'    =>  [
        'PAYMENT_CALLBACK' => env('APP_URL').'/payment/callback',
    ]
];
