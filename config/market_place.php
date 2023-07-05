<?php
return [
    'type_market' => [
        0 => 'Shopee',
        1 => 'Tiki',
        2 => 'Sendo',
        3 => 'Lazada',
    ],

    'market_key' => [
        'shopee' => 0,
        'tiki' => 1,
        'sendo' => 2,
        'lazada' => 3,
    ],
    'sendo' => [
        'product_status' => [
            0 => "Nháp",
            1 => "Chờ duyệt",
            2 => "Đang bán",
            3 => "Từ chối",
            4 => "Hủy",
            6 => "Đã xóa" 
        ],
        'login' => 'https://open.sendo.vn/login/',
        'product_list' => 'https://open.sendo.vn/api/partner/product/search/',
        'order_list' => 'https://open.sendo.vn/api/partner/salesorder/search/',
        'product_info_by_sku' => 'https://open.sendo.vn/api/partner/product?sku=',
        'product_info_by_id' => 'https://open.sendo.vn/api/partner/product?id=',
        'update_or_create_product' => 'https://open.sendo.vn/api/partner/product',
        'update_or_create_multi_products' => 'https://open.sendo.vn/api/partner/product/list',
    ],

    'tiki' => [
        'login' => 'https://api.tiki.vn/sc/oauth2/auth?response_type=code&client_id=',
        'access_token' => 'https://api.tiki.vn/sc/oauth2/token',
        'client_id' => '7305437757697606',
//        'client_id' => '6564066581661941',
//        'secret_key' => 'I1kCGB3ce0d16TOmXpwkJ7KA-Y6v536I',
        'secret_key' => '-Wbl2hJfZMTmB69Y2Bw7HQjA99yJmL1l',
        'scope' => 'all inventory offline order product',
        'information' => 'https://api.tiki.vn/integration/v1/sellers/me',
        'product_info_by_sku' => 'https://api.tiki.vn/integration/v2/products/findBy?original_sku=',
        'update_price_and_quantity' => 'https://api.tiki.vn/integration/v2/products/updateSku',
        'update_price_and_quantity_multi_products' => 'https://api.tiki.vn/integration/v2/products/updateSkus',
    ],

    'lazada' => [
        'product_status' => [
            'active' => "Đang bán",
        ],
        'login' => 'https://auth.lazada.com/oauth/authorize?',
        'client_id' => '103970',
        'secret_key' => 'JUq8YJWg9T5EFhADukbqoSTFCxtvuSsy',
        'logo' => '/assets/img/market_place/icon-lazada.png',
        'create_token' => '/auth/token/create',
        'product_info_by_sku' => '/product/item/get',
        'product_update' => '/product/update',
        'product_update_price_quantity' => '/product/price_quantity/update',
    ],

];
