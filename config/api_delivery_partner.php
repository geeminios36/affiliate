<?php
return [
    'ghn' => [
        'shop' => 'https://' . (config('constants.is_delivery_online') ? '' : 'dev-') . 'online-gateway.ghn.vn/shiip/public-api/v2/shop/all',
        'district' => 'https://' . (config('constants.is_delivery_online') ? '' : 'dev-') . 'online-gateway.ghn.vn/shiip/public-api/master-data/district',
        'ward' => 'https://' . (config('constants.is_delivery_online') ? '' : 'dev-') . 'online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id=',
        'pick_shift' => 'https://' . (config('constants.is_delivery_online') ? '' : 'dev-') . 'online-gateway.ghn.vn/shiip/public-api/v2/shift/date',
        'create_order' => 'https://' . (config('constants.is_delivery_online') ? '' : 'dev-') . 'online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/create',
        'order_detail' => 'https://' . (config('constants.is_delivery_online') ? '' : 'dev-') . 'online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/detail',
        'preview' => 'https://' . (config('constants.is_delivery_online') ? '' : 'dev-') . 'online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/preview',
    ],
    'ghtk' => [
        'shop' => 'https://services.giaohangtietkiem.vn/services/shipment/list_pick_add',
        'xfast_check' => 'https://services.giaohangtietkiem.vn/services/shipment/x-team?',
        'delivery_fee' => 'https://services.giaohangtietkiem.vn/services/shipment/fee?',
        'create_order' => 'https://services.giaohangtietkiem.vn/services/shipment/order',
        'order_detail' => 'https://services.giaohangtietkiem.vn/services/shipment/v2/',
    ],
    'bestexpress' => [
        'shop' => 'https://v9-cc.800best.com/uc/account/login',
    ]
];
