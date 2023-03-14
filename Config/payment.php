<?php
return [

    'ZARINPAL' => [
        'IS_TEST' => true,

        'API_KEY'  =>  '',

        'SEND' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',
        'GATE'  =>  'https://www.zarinpal.com/pg/StartPay/',

        'TEST_SEND'   =>  'https://sandbox.zarinpal.com/pg/services/WebGate/wsdl',
        'TEST_GATE' =>  'https://sandbox.zarinpal.com/pg/StartPay/',
    ],

    'PAYMENT_CALLBACK' => '/payment/callback',
];
