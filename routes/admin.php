<?php

/*
  |--------------------------------------------------------------------------
  | Admin Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register admin routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::post('/update', 'UpdateController@step0')->name('update');
Route::get('/update/step1', 'UpdateController@step1')->name('update.step1');
Route::get('/update/step2', 'UpdateController@step2')->name('update.step2');

Route::get('/admin', 'HomeController@admin_dashboard')->name('admin.dashboard')->middleware(['auth', 'admin']);
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    //Update Routes

    Route::resource('categories', 'CategoryController');
    Route::get('/categories/edit/{id}', 'CategoryController@edit')->name('categories.edit');
    Route::get('/categories/destroy/{id}', 'CategoryController@destroy')->name('categories.destroy');
    Route::post('/categories/featured', 'CategoryController@updateFeatured')->name('categories.featured');
    Route::post('/categories/enabled', 'CategoryController@updateEnabled')->name('categories.enabled');

    Route::resource('brands', 'BrandController');
    Route::get('/brands/edit/{id}', 'BrandController@edit')->name('brands.edit');
    Route::get('/brands/destroy/{id}', 'BrandController@destroy')->name('brands.destroy');

    Route::get('/products/admin', 'ProductController@admin_products')->name('products.admin');
    Route::get('/products/seller', 'ProductController@seller_products')->name('products.seller');
    Route::get('/products/all', 'ProductController@all_products')->name('products.all');
    Route::get('/products/create', 'ProductController@create')->name('products.create');
    Route::get('/products/admin/{id}/edit', 'ProductController@admin_product_edit')->name('products.admin.edit');
    Route::get('/products/seller/{id}/edit', 'ProductController@seller_product_edit')->name('products.seller.edit');
    Route::post('/products/todays_deal', 'ProductController@updateTodaysDeal')->name('products.todays_deal');
    Route::post('/products/featured', 'ProductController@updateFeatured')->name('products.featured');
    Route::post('/products/get_products_by_subcategory', 'ProductController@get_products_by_subcategory')->name('products.get_products_by_subcategory');
    Route::post('/bulk-product-delete', 'ProductController@bulk_product_delete')->name('bulk-product-delete');

    Route::resource('config_commission', 'ConfigCommissionController');

    Route::resource('sellers', 'SellerController');
    Route::get('sellers_ban/{id}', 'SellerController@ban')->name('sellers.ban');
    Route::get('/sellers/destroy/{id}', 'SellerController@destroy')->name('sellers.destroy');
    Route::post('/bulk-seller-delete', 'SellerController@bulk_seller_delete')->name('bulk-seller-delete');
    Route::get('/sellers/view/{id}/verification', 'SellerController@show_verification_request')->name('sellers.show_verification_request');
    Route::get('/sellers/approve/{id}', 'SellerController@approve_seller')->name('sellers.approve');
    Route::get('/sellers/reject/{id}', 'SellerController@reject_seller')->name('sellers.reject');
    Route::get('/sellers/login/{id}', 'SellerController@login')->name('sellers.login');
    Route::post('/sellers/payment_modal', 'SellerController@payment_modal')->name('sellers.payment_modal');
    Route::get('/seller/payments', 'PaymentController@payment_histories')->name('sellers.payment_histories');
    Route::get('/seller/payments/show/{id}', 'PaymentController@show')->name('sellers.payment_history');

    Route::resource('customers', 'CustomerController');
    Route::get('customers_ban/{customer}', 'CustomerController@ban')->name('customers.ban');
    Route::get('/customers/login/{id}', 'CustomerController@login')->name('customers.login');
    Route::get('/customers/destroy/{id}', 'CustomerController@destroy')->name('customers.destroy');
    Route::post('/bulk-customer-delete', 'CustomerController@bulk_customer_delete')->name('bulk-customer-delete');

    Route::get('/newsletter', 'NewsletterController@index')->name('newsletters.index');
    Route::post('/newsletter/send', 'NewsletterController@send')->name('newsletters.send');
    Route::post('/newsletter/test/smtp', 'NewsletterController@testEmail')->name('test.smtp');

    Route::resource('profile', 'ProfileController');

    Route::post('/business-settings/update', 'BusinessSettingsController@update')->name('business_settings.update');
    Route::post('/business-settings/update/activation', 'BusinessSettingsController@updateActivationSettings')->name('business_settings.update.activation');
    Route::get('/general-setting', 'BusinessSettingsController@general_setting')->name('general_setting.index');
    Route::get('/activation', 'BusinessSettingsController@activation')->name('activation.index');
    Route::get('/payment-method', 'BusinessSettingsController@payment_method')->name('payment_method.index');
    Route::get('/file_system', 'BusinessSettingsController@file_system')->name('file_system.index');
    Route::get('/social-login', 'BusinessSettingsController@social_login')->name('social_login.index');
    Route::get('/smtp-settings', 'BusinessSettingsController@smtp_settings')->name('smtp_settings.index');
    Route::get('/google-analytics', 'BusinessSettingsController@google_analytics')->name('google_analytics.index');
    Route::get('/google-recaptcha', 'BusinessSettingsController@google_recaptcha')->name('google_recaptcha.index');
    Route::post('/business-settings/ajax', 'BusinessSettingsController@updateAjax')->name('business_settings.updateAjax');

    //Facebook Settings
    Route::get('/facebook-chat', 'BusinessSettingsController@facebook_chat')->name('facebook_chat.index');
    Route::post('/facebook_chat', 'BusinessSettingsController@facebook_chat_update')->name('facebook_chat.update');
    Route::get('/facebook-comment', 'BusinessSettingsController@facebook_comment')->name('facebook-comment');
    Route::post('/facebook-comment', 'BusinessSettingsController@facebook_comment_update')->name('facebook-comment.update');
    Route::post('/facebook_pixel', 'BusinessSettingsController@facebook_pixel_update')->name('facebook_pixel.update');

    Route::post('/env_key_update', 'BusinessSettingsController@env_key_update')->name('env_key_update.update');
    Route::post('/payment_method_update', 'BusinessSettingsController@payment_method_update')->name('payment_method.update');
    Route::post('/google_analytics', 'BusinessSettingsController@google_analytics_update')->name('google_analytics.update');
    Route::post('/google_recaptcha', 'BusinessSettingsController@google_recaptcha_update')->name('google_recaptcha.update');
    //Currency
    Route::get('/currency', 'CurrencyController@currency')->name('currency.index');
    Route::post('/currency/update', 'CurrencyController@updateCurrency')->name('currency.update');
    Route::post('/your-currency/update', 'CurrencyController@updateYourCurrency')->name('your_currency.update');
    Route::get('/currency/create', 'CurrencyController@create')->name('currency.create');
    Route::post('/currency/store', 'CurrencyController@store')->name('currency.store');
    Route::post('/currency/currency_edit', 'CurrencyController@edit')->name('currency.edit');
    Route::post('/currency/update_status', 'CurrencyController@update_status')->name('currency.update_status');

    //Tax
    Route::resource('tax', 'TaxController');
    Route::get('/tax/edit/{id}', 'TaxController@edit')->name('tax.edit');
    Route::get('/tax/destroy/{id}', 'TaxController@destroy')->name('tax.destroy');
    Route::post('tax-status', 'TaxController@change_tax_status')->name('taxes.tax-status');


    Route::get('/verification/form', 'BusinessSettingsController@seller_verification_form')->name('seller_verification_form.index');
    Route::post('/verification/form', 'BusinessSettingsController@seller_verification_form_update')->name('seller_verification_form.update');
    Route::get('/vendor_commission', 'BusinessSettingsController@vendor_commission')->name('business_settings.vendor_commission');
    Route::post('/vendor_commission_update', 'BusinessSettingsController@vendor_commission_update')->name('business_settings.vendor_commission.update');

    Route::resource('/languages', 'LanguageController');
    Route::post('/languages/{id}/update', 'LanguageController@update')->name('languages.update');
    Route::get('/languages/destroy/{id}', 'LanguageController@destroy')->name('languages.destroy');
    Route::post('/languages/update_rtl_status', 'LanguageController@update_rtl_status')->name('languages.update_rtl_status');
    Route::post('/languages/key_value_store', 'LanguageController@key_value_store')->name('languages.key_value_store');

    // website setting
    Route::group(['prefix' => 'website'], function () {
        Route::view('/header', 'backend.website_settings.header')->name('website.header');
        Route::view('/footer', 'backend.website_settings.footer')->name('website.footer');
        Route::view('/pages', 'backend.website_settings.pages.index')->name('website.pages');
        Route::view('/appearance', 'backend.website_settings.appearance')->name('website.appearance');
        Route::resource('custom-pages', 'PageController');
        Route::get('/custom-pages/edit/{id}', 'PageController@edit')->name('custom-pages.edit');
        Route::get('/custom-pages/destroy/{id}', 'PageController@destroy')->name('custom-pages.destroy');
    });

    Route::resource('roles', 'RoleController')->middleware(['auth', 'factory']);
    Route::get('/roles/edit/{id}', 'RoleController@edit')->name('roles.edit');
    Route::get('/roles/destroy/{id}', 'RoleController@destroy')->name('roles.destroy');


    Route::resource('staffs', 'StaffController');
    Route::get('/staffs/create', 'StaffController@create')->name('staffs.create');
    Route::get('/staffs/edit/{id}', 'StaffController@edit')->name('staffs.edit');;
    Route::get('/staffs/destroy/{id}', 'StaffController@destroy')->name('staffs.destroy');

    Route::resource('flash_deals', 'FlashDealController');
    Route::get('/flash_deals/edit/{id}', 'FlashDealController@edit')->name('flash_deals.edit');
    Route::get('/flash_deals/destroy/{id}', 'FlashDealController@destroy')->name('flash_deals.destroy');
    Route::post('/flash_deals/update_status', 'FlashDealController@update_status')->name('flash_deals.update_status');
    Route::post('/flash_deals/update_featured', 'FlashDealController@update_featured')->name('flash_deals.update_featured');
    Route::post('/flash_deals/product_discount', 'FlashDealController@product_discount')->name('flash_deals.product_discount');
    Route::post('/flash_deals/product_discount_edit', 'FlashDealController@product_discount_edit')->name('flash_deals.product_discount_edit');

    //Subscribers
    Route::get('/subscribers', 'SubscriberController@index')->name('subscribers.index');
    Route::get('/subscribers/destroy/{id}', 'SubscriberController@destroy')->name('subscriber.destroy');

    // Route::get('/orders', 'OrderController@admin_orders')->name('orders.index.admin');
    // Route::get('/orders/{id}/show', 'OrderController@show')->name('orders.show');
    // Route::get('/sales/{id}/show', 'OrderController@sales_show')->name('sales.show');
    // Route::get('/sales', 'OrderController@sales')->name('sales.index');
    // All Orders
    Route::get('/all_orders', 'OrderController@all_orders')->name('all_orders.index');
    Route::get('/all_orders/{id}/show', 'OrderController@all_orders_show')->name('all_orders.show');
    // Inhouse Orders
    Route::get('/inhouse-orders', 'OrderController@admin_orders')->name('inhouse_orders.index');
    Route::get('/inhouse-orders/{id}/show', 'OrderController@show')->name('inhouse_orders.show');

    // Seller Orders
    Route::get('/seller_orders', 'OrderController@seller_orders')->name('seller_orders.index');
    Route::get('/seller_orders/{id}/show', 'OrderController@seller_orders_show')->name('seller_orders.show');

    Route::post('/bulk-order-status', 'OrderController@bulk_order_status')->name('bulk-order-status');


    // Pickup point orders
    Route::get('orders_by_pickup_point', 'OrderController@pickup_point_order_index')->name('pick_up_point.order_index');
    Route::get('/orders_by_pickup_point/{id}/show', 'OrderController@pickup_point_order_sales_show')->name('pick_up_point.order_show');

    Route::get('/orders/destroy/{id}', 'OrderController@destroy')->name('orders.destroy');
    Route::post('/bulk-order-delete', 'OrderController@bulk_order_delete')->name('bulk-order-delete');

    Route::post('/pay_to_seller', 'CommissionController@pay_to_seller')->name('commissions.pay_to_seller');

    //Reports
    Route::get('/stock_report', 'ReportController@stock_report')->name('stock_report.index');
    Route::get('/in_house_sale_report', 'ReportController@in_house_sale_report')->name('in_house_sale_report.index');
    Route::get('/seller_sale_report', 'ReportController@seller_sale_report')->name('seller_sale_report.index');
    Route::get('/wish_report', 'ReportController@wish_report')->name('wish_report.index');
    Route::get('/user_search_report', 'ReportController@user_search_report')->name('user_search_report.index');
    Route::get('/wallet-history', 'ReportController@wallet_transaction_history')->name('wallet-history.index');

    //Blog Section
    Route::resource('blog-category', 'BlogCategoryController');
    Route::get('/blog-category/destroy/{id}', 'BlogCategoryController@destroy')->name('blog-category.destroy');
    Route::resource('blog', 'BlogController');
    Route::get('/blog/destroy/{id}', 'BlogController@destroy')->name('blog.destroy');
    Route::post('/blog/change-status', 'BlogController@change_status')->name('blog.change-status');

    //Coupons
    Route::resource('coupon', 'CouponController');
    Route::post('/coupon/get_form', 'CouponController@get_coupon_form')->name('coupon.get_coupon_form');
    Route::post('/coupon/get_form_edit', 'CouponController@get_coupon_form_edit')->name('coupon.get_coupon_form_edit');
    Route::get('/coupon/destroy/{id}', 'CouponController@destroy')->name('coupon.destroy');

    //Reviews
    Route::get('/reviews', 'ReviewController@index')->name('reviews.index');
    Route::post('/reviews/published', 'ReviewController@updatePublished')->name('reviews.published');

    //Support_Ticket
    Route::get('support_ticket/', 'SupportTicketController@admin_index')->name('support_ticket.admin_index');
    Route::get('support_ticket/{id}/show', 'SupportTicketController@admin_show')->name('support_ticket.admin_show');
    Route::post('support_ticket/reply', 'SupportTicketController@admin_store')->name('support_ticket.admin_store');

    //Pickup_Points
    Route::resource('pick_up_points', 'PickupPointController');
    Route::get('/pick_up_points/edit/{id}', 'PickupPointController@edit')->name('pick_up_points.edit');
    Route::get('/pick_up_points/destroy/{id}', 'PickupPointController@destroy')->name('pick_up_points.destroy');

    //conversation of seller customer
    Route::get('conversations', 'ConversationController@admin_index')->name('conversations.admin_index');
    Route::get('conversations/{id}/show', 'ConversationController@admin_show')->name('conversations.admin_show');

    Route::post('/sellers/profile_modal', 'SellerController@profile_modal')->name('sellers.profile_modal');
    Route::post('/sellers/approved', 'SellerController@updateApproved')->name('sellers.approved');

    Route::resource('attributes', 'AttributeController');
    Route::get('/attributes/edit/{id}', 'AttributeController@edit')->name('attributes.edit');
    Route::get('/attributes/destroy/{id}', 'AttributeController@destroy')->name('attributes.destroy');

    //Attribute Value
    Route::post('/store-attribute-value', 'AttributeController@store_attribute_value')->name('store-attribute-value');
    Route::get('/edit-attribute-value/{id}', 'AttributeController@edit_attribute_value')->name('edit-attribute-value');
    Route::post('/update-attribute-value/{id}', 'AttributeController@update_attribute_value')->name('update-attribute-value');
    Route::get('/destroy-attribute-value/{id}', 'AttributeController@destroy_attribute_value')->name('destroy-attribute-value');

    //Colors
    Route::get('/colors', 'AttributeController@colors')->name('colors');
    Route::post('/colors/store', 'AttributeController@store_color')->name('colors.store');
    Route::get('/colors/edit/{id}', 'AttributeController@edit_color')->name('colors.edit');
    Route::post('/colors/update/{id}', 'AttributeController@update_color')->name('colors.update');
    Route::get('/colors/destroy/{id}', 'AttributeController@destroy_color')->name('colors.destroy');

    Route::resource('addons', 'AddonController');
    Route::post('/addons/activation', 'AddonController@activation')->name('addons.activation');

    Route::get('/customer-bulk-upload/index', 'CustomerBulkUploadController@index')->name('customer_bulk_upload.index');
    Route::post('/bulk-user-upload', 'CustomerBulkUploadController@user_bulk_upload')->name('bulk_user_upload');
    Route::post('/bulk-customer-upload', 'CustomerBulkUploadController@customer_bulk_file')->name('bulk_customer_upload');
    Route::get('/user', 'CustomerBulkUploadController@pdf_download_user')->name('pdf.download_user');
    //Customer Package

    Route::resource('customer_packages', 'CustomerPackageController');
    Route::get('/customer_packages/edit/{id}', 'CustomerPackageController@edit')->name('customer_packages.edit');
    Route::get('/customer_packages/destroy/{id}', 'CustomerPackageController@destroy')->name('customer_packages.destroy');

    // //Classified Products
    // Route::get('/classified_products', 'CustomerProductController@customer_product_index')->name('classified_products');
    // Route::post('/classified_products/published', 'CustomerProductController@updatePublished')->name('classified_products.published');

    //Shipping Configuration
    Route::get('/shipping_configuration', 'BusinessSettingsController@shipping_configuration')->name('shipping_configuration.index');
    Route::post('/shipping_configuration/update', 'BusinessSettingsController@shipping_configuration_update')->name('shipping_configuration.update');

    // Route::resource('pages', 'PageController');
    // Route::get('/pages/destroy/{id}', 'PageController@destroy')->name('pages.destroy');

    Route::resource('countries', 'CountryController');
    Route::post('/countries/status', 'CountryController@updateStatus')->name('countries.status');

    Route::resource('cities', 'CityController');
    Route::get('/cities/edit/{id}', 'CityController@edit')->name('cities.edit');
    Route::get('/cities/destroy/{id}', 'CityController@destroy')->name('cities.destroy');

    Route::view('/system/update', 'backend.system.update')->name('system_update');
    Route::view('/system/server-status', 'backend.system.server_status')->name('system_server');

    // uploaded files
    Route::any('/uploaded-files/file-info', 'AizUploadController@file_info')->name('uploaded-files.info');
    Route::resource('/uploaded-files', 'AizUploadController');
    Route::get('/uploaded-files/destroy/{id}', 'AizUploadController@destroy')->name('uploaded-files.destroy');

    //Delivery
    Route::group(['prefix' => 'delivery'], function () {
        Route::get('/partner', 'DeliveryController@index')->name('delivery.partner');
        Route::post('/reload', 'DeliveryController@reload')->name('delivery.reload');
        Route::post('/update_delivery/{delivery_tenancy_id?}', 'DeliveryController@updateDelivery')->name('delivery.update_delivery');

        //giao hàng nhanh
        Route::post('/save_connect_ghn', 'DeliveryController@saveConnectGHN')->name('delivery.save_connect_ghn');
        Route::post('/logout_delivery/{delivery_tenancy_id?}', 'DeliveryController@logOutDelivery')->name('delivery.logout_delivery');
        Route::get('/partner/shippers/{delivery_tenancies_id}', 'ShipperController@shippers')->name('delivery.partner.shippers');

        //giao hàng tiết kiệm
        Route::post('/login_ghtk', 'DeliveryController@loginGHTK')->name('delivery.login_ghtk');
        Route::post('/save_connect_ghtk', 'DeliveryController@saveConnectGHTK')->name('delivery.save_connect_ghtk');

        //Viettel Post
        Route::post('/login_viettel_post', 'DeliveryController@loginViettelPost')->name('delivery.login_viettel_post');

        //Best Express
        Route::post('/login_best_express', 'DeliveryController@loginBestExpress')->name('delivery.login_best_express');
    });

    //Market Place
    Route::group(['prefix' => 'market-place'], function () {
        Route::get('/index', 'EcommerceMarketPlaceController@index')->name('market_place.index');
        Route::get('/connect', 'EcommerceMarketPlaceController@connect')->name('market_place.connect');

        Route::get('/general-page', 'EcommerceMarketPlaceController@generalPage')->name('market_place.general_page');
        Route::get('/config/{ecommerceMarketPlaceId?}', 'EcommerceMarketPlaceController@configMarket')->name('market_place.config_market');
        Route::get('/general-page_data/{ecommerceMarketPlaceId?}', 'EcommerceMarketPlaceController@configMarketData')->name('market_place.general_page_data');
        Route::get('/custom-config/{ecommerceMarketPlaceId?}', 'EcommerceMarketPlaceController@customConfig')->name('market_place.custom_config');

        Route::post('/save-config/{ecommerceMarketPlaceId?}', 'EcommerceMarketPlaceController@saveConfig')->name('market_place.save_config');

        //product
        Route::group(['prefix' => 'product'], function () {
            Route::get('/', 'EcommerceProductController@index')->name('market_place.product');
            Route::get('/list_data', 'EcommerceProductController@listData')->name('market_place.product.list_data');
            Route::post('/list_data_product', 'EcommerceProductController@listDataProduct')->name('market_place.product.list_data_product');
            Route::post('/get_list_variant', 'EcommerceProductController@getListVariant')->name('market_place.product.get_list_variant');
            Route::post('/link_each_product', 'EcommerceProductController@linkEachProduct')->name('market_place.product.link_each_product');
            Route::post('/detail_product_synced', 'EcommerceProductController@detailProductSynced')->name('market_place.product.detail_product_synced');
            Route::post('/disconnect_product', 'EcommerceProductController@disconnectProduct')->name('market_place.product.disconnect_product');
            Route::post('/link_multi_product_by_market', 'EcommerceProductController@linkMultiProductByMarket')->name('market_place.product.link_multi_product_by_market');
            Route::post('/sync_all_product', 'EcommerceProductController@syncAllProduct')->name('market_place.product.sync_all_product');
        });
        //product_affiliate
        Route::group(['prefix' => 'product_affiliate'], function () {
            Route::get('/', 'EcommerceProductAffiliateController@index')->name('market_place.product_affiliate');
            Route::get('/list_data_product', 'EcommerceProductAffiliateController@listDataProduct')->name('market_place.product_affiliate.list_data_product');
            Route::post('/data_product_filter', 'EcommerceProductAffiliateController@dataProductFilter')->name('market_place.product_affiliate.data_product_filter');
            Route::post('/link_product/{productStockId?}/{ecommerceMarketPlaceId?}', 'EcommerceProductAffiliateController@linkProduct')->name('market_place.product_affiliate.link_product');
            Route::post('/link_multi_products/', 'EcommerceProductAffiliateController@linkMultiProducts')->name('market_place.product_affiliate.link_multi_products');
            Route::post('/disconnect_product/{productLinkedId?}/{ecommerceMarketPlaceId?}', 'EcommerceProductAffiliateController@disconnectProduct')->name('market_place.product_affiliate.disconnect_product');
            Route::post('/syncing', 'EcommerceProductAffiliateController@syncing')->name('market_place.product_affiliate.syncing');
        });

        //sendo
        Route::group(['prefix' => 'sendo'], function () {
            Route::get('/connect', 'SendoController@connect')->name('market_place.sendo.connect');
            Route::post('/connecting', 'SendoController@connecting')->name('market_place.sendo.connecting');
        });

        //tiki
        Route::group(['prefix' => 'tiki'], function () {
            Route::get('/connect', 'TikiController@connect')->name('market_place.tiki.connect');
        });

        //lazada
        Route::group(['prefix' => 'lazada'], function () {
            Route::get('/connect', 'LazadaController@connect')->name('market_place.lazada.connect');
        });
    });

    Route::resource('tenants', 'TenantManagerController');
    Route::post('/tenants/status', 'TenantManagerController@updateStatus')->name('tenants.status');
    Route::get('/tenants/destroy/{id}', 'TenantManagerController@destroy')->name('tenants.destroy');

    Route::group(['prefix' => 'wallet'], function () {
        Route::get('/', 'AdminWalletController@index')->name('admin.wallet.index');
        Route::post('/recharge', 'AdminWalletController@recharge')->name('admin.wallet.recharge');
        Route::post('/offline-wallet-recharge-modal', 'AdminWalletController@offline_recharge_modal')->name('admin.offline_wallet_recharge_modal');
        Route::post('/offline-wallet-recharge', 'AdminWalletController@offline_recharge')->name('admin.wallet_recharge.make_payment');
    });
});
