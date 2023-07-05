<?php
return [
    'momo' => [
        'sandbox' => 'https://test-payment.momo.vn/v2/gateway/api/create',
        'prod' => 'https://payment.momo.vn/v2/gateway/api/create',
    ],
    'vnpay' => [
        'sandbox' => 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html',
        'prod' => '',
    ],
    'appotapay' => [
        'sandbox' => 'https://payment.dev.appotapay.com/api/v1.1/orders/payment/bank	',
        'prod' => 'https://payment.appotapay.com/api/v1.1/orders/payment/bank',
    ],
];
