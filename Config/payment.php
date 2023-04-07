<?php
return [

    'ZARINPAL' => [
        'IS_TEST' => true,

        'API_KEY'  =>  '1122334455667788998811223344556677',

        'SEND' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',
        'GATE'  =>  'https://www.zarinpal.com/pg/StartPay/',

        'TEST_SEND'   =>  'https://sandbox.zarinpal.com/pg/services/WebGate/wsdl',
        'TEST_GATE' =>  'https://sandbox.zarinpal.com/pg/StartPay/',
    ],

    'PAYMENT_CALLBACK' => env('APP_URL').'/payment/callback',
];
