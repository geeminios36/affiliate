<?php

use App\Http\Controllers\ClubPointController;
use App\Http\Controllers\AffiliateController;

use App\Currency;
use App\BusinessSetting;
use App\Product;
use App\Address;
use App\SubSubCategory;
use App\FlashDealProduct;
use App\CustomerPackage;
use App\FlashDeal;
use App\OtpConfiguration;
use App\Upload;
use App\Translation;
use App\City;
use App\CommissionHistory;
use App\Utility\TranslationUtility;
use App\Utility\CategoryUtility;
use App\Utility\MimoUtility;
use Twilio\Rest\Client;
use App\Wallet;
use App\Order;
use App\User;

//highlights the selected navigation on admin panel
if (!function_exists('sendSMS')) {
    function sendSMS($to, $from, $text, $template_id = null)
    {
        if (OtpConfiguration::where('type', 'nexmo')->first()->value == 1) {
            $api_key = env("NEXMO_KEY"); //put ssl provided api_token here
            $api_secret = env("NEXMO_SECRET"); // put ssl provided sid here

            $params = [
                "api_key" => $api_key,
                "api_secret" => $api_secret,
                "from" => $from,
                "text" => $text,
                "to" => $to
            ];

            $url = "https://rest.nexmo.com/sms/json";
            $params = json_encode($params);

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params),
                'accept:application/json'
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            return $response;
        } elseif (OtpConfiguration::where('type', 'twillo')->first()->value == 1) {
            $sid = env("TWILIO_SID"); // Your Account SID from www.twilio.com/console
            $token = env("TWILIO_AUTH_TOKEN"); // Your Auth Token from www.twilio.com/console

            $client = new Client($sid, $token);
            try {
                $message = $client->messages->create(
                    $to, // Text this number
                    array(
                        'from' => env('VALID_TWILLO_NUMBER'), // From a valid Twilio number
                        'body' => $text
                    )
                );
            } catch (\Exception $e) {
            }
        } elseif (OtpConfiguration::where('type', 'ssl_wireless')->first()->value == 1) {
            $token = env("SSL_SMS_API_TOKEN"); //put ssl provided api_token here
            $sid = env("SSL_SMS_SID"); // put ssl provided sid here

            $params = [
                "api_token" => $token,
                "sid" => $sid,
                "msisdn" => $to,
                "sms" => $text,
                "csms_id" => date('dmYhhmi') . rand(10000, 99999)
            ];

            $url = env("SSL_SMS_URL");
            $params = json_encode($params);

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params),
                'accept:application/json'
            ));

            $response = curl_exec($ch);

            curl_close($ch);

            return $response;
        } elseif (OtpConfiguration::where('type', 'fast2sms')->first()->value == 1) {

            if (strpos($to, '+91') !== false) {
                $to = substr($to, 3);
            }

            if (env("ROUTE") == 'dlt_manual') {
                $fields = array(
                    "sender_id" => env("SENDER_ID"),
                    "message" => $text,
                    "template_id" => $template_id,
                    "entity_id" => env("ENTITY_ID"),
                    "language" => env("LANGUAGE"),
                    "route" => env("ROUTE"),
                    "numbers" => $to,
                );
            } else {
                $fields = array(
                    "sender_id" => env("SENDER_ID"),
                    "message" => $text,
                    "language" => env("LANGUAGE"),
                    "route" => env("ROUTE"),
                    "numbers" => $to,
                );
            }


            $auth_key = env('AUTH_KEY');

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($fields),
                CURLOPT_HTTPHEADER => array(
                    "authorization: $auth_key",
                    "accept: */*",
                    "cache-control: no-cache",
                    "content-type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            return $response;
        } elseif (OtpConfiguration::where('type', 'mimo')->first()->value == 1) {
            $token = MimoUtility::getToken();

            MimoUtility::sendMessage($text, $to, $token);
            MimoUtility::logout($token);
        }
    }
}

//highlights the selected navigation on admin panel
if (!function_exists('areActiveRoutes')) {
    function areActiveRoutes(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
    }
}

//highlights the selected navigation on frontend
if (!function_exists('areActiveRoutesHome')) {
    function areActiveRoutesHome(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
    }
}

//highlights the selected navigation on frontend
if (!function_exists('default_language')) {
    function default_language()
    {
        return env("DEFAULT_LANGUAGE");
    }
}

/**
 * Save JSON File
 * @return Response
 */
if (!function_exists('convert_to_usd')) {
    function convert_to_usd($amount)
    {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if ($business_settings != null) {
            $currency = Currency::where('id', $business_settings->value)->first();
            return (floatval($amount) / floatval($currency->exchange_rate)) * Currency::where('code', 'USD')->first()->exchange_rate;
        }
    }
}

if (!function_exists('convert_to_kes')) {
    function convert_to_kes($amount)
    {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if ($business_settings != null) {
            $currency = Currency::where('id', $business_settings->value)->first();
            return (floatval($amount) / floatval($currency->exchange_rate)) * Currency::where('code', 'KES')->first()->exchange_rate;
        }
    }
}

//filter products based on vendor activation system
if (!function_exists('filter_products')) {
    function filter_products($products)
    {
        $verified_sellers = verified_sellers_id();
        if (BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1) {
            return $products->where('published', '1')->orderBy('created_at', 'desc')->where(function ($p) use ($verified_sellers) {
                $p->where('added_by', 'admin')->orWhere(function ($q) use ($verified_sellers) {
                    $q->whereIn('user_id', $verified_sellers);
                });
            });
        } else {
            return $products->where('published', '1')->where('added_by', 'admin');
        }
    }
}

//cache products based on category
if (!function_exists('get_cached_products')) {
    function get_cached_products($category_id = null)
    {
        $products = \App\Product::where('published', 1);
        $verified_sellers = verified_sellers_id();
        if (BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1) {
            $products = $products->where(function ($p) use ($verified_sellers) {
                $p->where('added_by', 'admin')->orWhere(function ($q) use ($verified_sellers) {
                    $q->whereIn('user_id', $verified_sellers);
                });
            });
        } else {
            $products = $products->where('added_by', 'admin');
        }

        if ($category_id != null) {
            return Cache::remember('products-category-' . $category_id, 86400, function () use ($category_id, $products) {
                $category_ids = CategoryUtility::children_ids($category_id);
                $category_ids[] = $category_id;
                return $products->whereIn('category_id', $category_ids)->latest()->take(12)->get();
            });
        } else {
            return Cache::remember('products', 86400, function () use ($products) {
                return $products->latest()->get();
            });
        }
    }
}

if (!function_exists('verified_sellers_id')) {
    function verified_sellers_id()
    {
        return App\Seller::where('verification_status', 1)->get()->pluck('user_id')->toArray();
    }
}

//converts currency to home default currency
if (!function_exists('convert_price')) {
    function convert_price($price)
    {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if ($business_settings != null) {
            $currency = Currency::find($business_settings->value);
            $price = floatval($price) / floatval($currency->exchange_rate);
        }

        $code = \App\Currency::findOrFail(get_setting('system_default_currency'))->code;
        if (Session::has('currency_code')) {
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        } else {
            $currency = Currency::where('code', $code)->first();
        }

        $price = floatval($price) * floatval($currency->exchange_rate);

        return $price;
    }
}

//formats currency
if (!function_exists('format_price')) {
    function format_price($price)
    {
        if (get_setting('decimal_separator') == 1) {
            $fomated_price = number_format($price, get_setting('no_of_decimals'));
        } else {
            $fomated_price = number_format($price, get_setting('no_of_decimals'), ',', ' ');
        }

        if (get_setting('symbol_format') == 1) {
            return currency_symbol() . $fomated_price;
        } else if (get_setting('symbol_format') == 3) {
            return currency_symbol() . ' ' . $fomated_price;
        } else if (get_setting('symbol_format') == 4) {
            return $fomated_price . ' ' . currency_symbol();
        }
        return $fomated_price . currency_symbol();
    }
}

//formats price to home default price with convertion
if (!function_exists('single_price')) {
    function single_price($price)
    {
        return format_price(convert_price($price));
    }
}

//Shows Price on page based on low to high
if (!function_exists('home_price')) {
    function home_price($product)
    {
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $lowest_price += ($lowest_price * $product_tax->tax) / 100;
                $highest_price += ($highest_price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $lowest_price += $product_tax->tax;
                $highest_price += $product_tax->tax;
            }
        }

        $lowest_price = convert_price($lowest_price);
        $highest_price = convert_price($highest_price);

        if ($lowest_price == $highest_price) {
            return format_price($lowest_price);
        } else {
            return format_price($lowest_price) . ' - ' . format_price($highest_price);
        }
    }
}

//Shows Price on page based on low to high with discount
if (!function_exists('home_discounted_price')) {
    function home_discounted_price($product)
    {
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $lowest_price -= ($lowest_price * $product->discount) / 100;
                $highest_price -= ($highest_price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $lowest_price -= $product->discount;
                $highest_price -= $product->discount;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $lowest_price += ($lowest_price * $product_tax->tax) / 100;
                $highest_price += ($highest_price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $lowest_price += $product_tax->tax;
                $highest_price += $product_tax->tax;
            }
        }

        $lowest_price = convert_price($lowest_price);
        $highest_price = convert_price($highest_price);

        if ($lowest_price == $highest_price) {
            return format_price($lowest_price);
        } else {
            return format_price($lowest_price) . ' - ' . format_price($highest_price);
        }
    }
}

//Shows Base Price
if (!function_exists('home_base_price_by_id')) {
    function home_base_price_by_id($id)
    {
        $product = Product::where('id', $id)->first();
        $price = $product->unit_price;
        $tax = 0;

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }
        $price += $tax;
        return format_price(convert_price($price));
    }
}
if (!function_exists('home_base_price')) {
    function home_base_price($product)
    {
        $price = $product->unit_price;
        $tax = 0;

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }
        $price += $tax;
        return format_price(convert_price($price));
    }
}

//Shows Base Price with discount
if (!function_exists('home_discounted_base_price_by_id')) {
    function home_discounted_base_price_by_id($id)
    {
        $product = Product::where('id', $id)->first();
        $price = $product->unit_price;
        $tax = 0;

        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }
        $price += $tax;

        return format_price(convert_price($price));
    }
}
//Shows Base Price with discount
if (!function_exists('home_discounted_base_price')) {
    function home_discounted_base_price($product)
    {
        $price = $product->unit_price;
        $tax = 0;

        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }
        $price += $tax;

        return format_price(convert_price($price));
    }
}

if (!function_exists('currency_symbol')) {
    function currency_symbol()
    {
        $code = \App\Currency::where('id', get_setting('system_default_currency'))->first()->code;
        if (Session::has('currency_code')) {
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        } else {
            $currency = Currency::where('code', $code)->first();
        }
        return $currency->symbol;
    }
}

if (!function_exists('renderStarRating')) {
    function renderStarRating($rating, $maxRating = 5)
    {
        $fullStar = "<i class = 'las la-star active'></i>";
        $halfStar = "<i class = 'las la-star half'></i>";
        $emptyStar = "<i class = 'las la-star'></i>";
        $rating = $rating <= $maxRating ? $rating : $maxRating;

        $fullStarCount = (int)$rating;
        $halfStarCount = ceil($rating) - $fullStarCount;
        $emptyStarCount = $maxRating - $fullStarCount - $halfStarCount;

        $html = str_repeat($fullStar, $fullStarCount);
        $html .= str_repeat($halfStar, $halfStarCount);
        $html .= str_repeat($emptyStar, $emptyStarCount);
        echo $html;
    }
}


//Api
if (!function_exists('homeBasePrice')) {
    function homeBasePrice($product)
    {
        $price = $product->unit_price;
        $tax = 0;
        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }

        $price += $tax;
        //        if ($product->tax_type == 'percent') {
        //            $price += ($price * $product->tax) / 100;
        //        } elseif ($product->tax_type == 'amount') {
        //            $price += $product->tax;
        //        }
        return $price;
    }
}

if (!function_exists('homeDiscountedBasePrice')) {
    function homeDiscountedBasePrice($product)
    {
        $price = $product->unit_price;
        $tax = 0;

        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }
        $price += $tax;
        return $price;
    }
}

if (!function_exists('homePrice')) {
    function homePrice($product)
    {
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;
        $tax = 0;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        //        if ($product->tax_type == 'percent') {
        //            $lowest_price += ($lowest_price*$product->tax)/100;
        //            $highest_price += ($highest_price*$product->tax)/100;
        //        }
        //        elseif ($product->tax_type == 'amount') {
        //            $lowest_price += $product->tax;
        //            $highest_price += $product->tax;
        //        }
        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $lowest_price += ($lowest_price * $product_tax->tax) / 100;
                $highest_price += ($highest_price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $lowest_price += $product_tax->tax;
                $highest_price += $product_tax->tax;
            }
        }

        $lowest_price = convertPrice($lowest_price);
        $highest_price = convertPrice($highest_price);

        return $lowest_price . ' - ' . $highest_price;
    }
}

if (!function_exists('homeDiscountedPrice')) {
    function homeDiscountedPrice($product)
    {
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $lowest_price -= ($lowest_price * $product->discount) / 100;
                $highest_price -= ($highest_price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $lowest_price -= $product->discount;
                $highest_price -= $product->discount;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $lowest_price += ($lowest_price * $product_tax->tax) / 100;
                $highest_price += ($highest_price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $lowest_price += $product_tax->tax;
                $highest_price += $product_tax->tax;
            }
        }

        $lowest_price = convertPrice($lowest_price);
        $highest_price = convertPrice($highest_price);

        return $lowest_price . ' - ' . $highest_price;
    }
}

if (!function_exists('brandsOfCategory')) {
    function brandsOfCategory($category_id)
    {
        $brands = [];
        $subCategories = SubCategory::where('category_id', $category_id)->get();
        foreach ($subCategories as $subCategory) {
            $subSubCategories = SubSubCategory::where('sub_category_id', $subCategory->id)->get();
            foreach ($subSubCategories as $subSubCategory) {
                $brand = json_decode($subSubCategory->brands);
                foreach ($brand as $b) {
                    if (in_array($b, $brands)) continue;
                    array_push($brands, $b);
                }
            }
        }
        return $brands;
    }
}

if (!function_exists('convertPrice')) {
    function convertPrice($price)
    {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if ($business_settings != null) {
            $currency = Currency::where('id', $business_settings->value)->first();
            $price = floatval($price) / floatval($currency->exchange_rate);
        }
        $code = Currency::where('id', BusinessSetting::where('type', 'system_default_currency')->first()->value)->first()->code;
        if (Session::has('currency_code')) {
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        } else {
            $currency = Currency::where('code', $code)->first();
        }
        $price = floatval($price) * floatval($currency->exchange_rate);
        return $price;
    }
}


function translate($key, $lang = null)
{
    if ($lang == null) {
        $lang = App::getLocale();
    }

    return __('app.' . $key);
}

function get_cart()
{
    $cart = [];

    if (auth()->user()) {
        $cart = \App\Cart::where('user_id', Auth::id())->get();
    } elseif (Session()->get('temp_user_id')) {
        $cart = \App\Cart::where('temp_user_id', Session()->get('temp_user_id'))->get();
    }

    return $cart;
}


function remove_invalid_charcaters($str)
{
    $str = str_ireplace(array("\\"), '', $str);
    return str_ireplace(array('"'), '\"', $str);
}

function getShippingCost($carts, $index)
{
    $admin_products = array();
    $seller_products = array();
    $calculate_shipping = 0;

    foreach ($carts as $key => $cartItem) {
        $product = \App\Product::where('id', $cartItem['product_id'])->first();
        if ($product->added_by == 'admin') {
            array_push($admin_products, $cartItem['product_id']);
        } else {
            $product_ids = array();
            if (array_key_exists($product->user_id, $seller_products)) {
                $product_ids = $seller_products[$product->user_id];
            }
            array_push($product_ids, $cartItem['product_id']);
            $seller_products[$product->user_id] = $product_ids;
        }
    }

    //Calculate Shipping Cost
    if (get_setting('shipping_type') == 'flat_rate') {
        $calculate_shipping = get_setting('flat_rate_shipping_cost');
    } elseif (get_setting('shipping_type') == 'seller_wise_shipping') {
        if (!empty($admin_products)) {
            $calculate_shipping = get_setting('shipping_cost_admin');
        }
        if (!empty($seller_products)) {
            foreach ($seller_products as $key => $seller_product) {
                $calculate_shipping += \App\Shop::where('user_id', $key)->first()->shipping_cost;
            }
        }
    } elseif (get_setting('shipping_type') == 'area_wise_shipping') {
        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
        $city = City::where('name', $shipping_info->city)->first();
        if ($city != null) {
            $calculate_shipping = $city->cost;
        }
    }

    $cartItem = $carts[$index];
    $product = \App\Product::where('id', $cartItem['product_id'])->first();

    if ($product->digital == 1) {
        return $calculate_shipping = 0;
    }

    if (get_setting('shipping_type') == 'flat_rate') {
        return $calculate_shipping / count($carts);
    } elseif (get_setting('shipping_type') == 'seller_wise_shipping') {
        if ($product->added_by == 'admin') {
            return get_setting('shipping_cost_admin') / count($admin_products);
        } else {
            return \App\Shop::where('user_id', $product->user_id)->first()->shipping_cost / count($seller_products[$product->user_id]);
        }
    } elseif (get_setting('shipping_type') == 'area_wise_shipping') {
        if ($product->added_by == 'admin') {
            return $calculate_shipping / count($admin_products);
        } else {
            return $calculate_shipping / count($seller_products[$product->user_id]);
        }
    } else {
        return \App\Product::where('id', $cartItem['product_id'])->first()->shipping_cost;
    }
}

function timezones()
{
    return Timezones::timezonesToArray();
}

if (!function_exists('app_timezone')) {
    function app_timezone()
    {
        return config('app.timezone');
    }
}

if (!function_exists('api_asset')) {
    function api_asset($id)
    {
        if (($asset = \App\Upload::where('id', $id)->first()) != null) {
            return my_asset($asset->file_name);
        }
        return "";
    }
}

//return file uploaded via uploader
if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {
        if (($asset = \App\Upload::where('id', $id)->first()) != null) {
            return my_asset($asset->file_name);
        } else {
            $asset = \App\Upload::withoutGlobalScope(new \App\Scopes\TenacyScope)->where('id', $id)->first();
            if ($asset != null) {
                return my_asset($asset->file_name);
            }
        }
        return '/assets/frontend/images/product/1_1-300x300.webp';
    }
}

//return file uploaded via uploader
if (!function_exists('uploaded_asset_logo')) {
    function uploaded_asset_logo($id)
    {
        if (($asset = \App\Upload::where('id', $id)->first()) != null) {
            return my_asset($asset->file_name);
        }
        return static_asset('assets/img/logo.png');
    }
}

if (!function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return Storage::disk('s3')->url($path);
        } else {
            return app('url')->asset($path, $secure);
        }
    }
}

if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}


if (!function_exists('isHttps')) {
    function isHttps()
    {
        return !empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']);
    }
}

if (!function_exists('getBaseURL')) {
    function getBaseURL()
    {
        $root = (isHttps() ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        return $root;
    }
}


if (!function_exists('getFileBaseURL')) {
    function getFileBaseURL()
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return env('AWS_URL', '/public') . '/';
        } else {
            return getBaseURL() . 'public/';
        }
    }
}


if (!function_exists('isUnique')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function isUnique($email)
    {
        $user = \App\User::where('email', $email)->first();

        if ($user == null) {
            return '1'; // $user = null means we did not get any match with the email provided by the user inside the database
        } else {
            return '0';
        }
    }
}

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        // $settings = Cache::remember('business_settings', 86400, function(){
        //     return BusinessSetting::all();
        // });

        // $setting = $settings->where('type', $key)->first();
        // return $setting == null ? $default : $setting->value;

        // $settings = Cache::remember('business_settings', 86400, function(){
        //     return BusinessSetting::all();
        // });
        $setting = BusinessSetting::where('type', $key)->first();
        return $setting == null ? $default : $setting->value;
    }
}
if (!function_exists('get_type_seller_withdraw_requests')) {
    function get_type_seller_withdraw_requests($key)
    {
        $types = [
            1 => 'Customer',
            2 => 'Seller',
            3 => 'Warehourse',
        ];
        if ($key < 0 || $key > count($types)) {
            return 'N/A';
        }

        return $types[$key];
    }
}

if (!function_exists('get_request_type_payments')) {
    function get_request_type_payments($key)
    {

        $types = [
            0 => 'Add Money',
            1 => 'With draw Money',
        ];
        if ($key < 0 || $key > count($types)) {
            return 'N/A';
        }
        return $types[$key];
    }
}
if (!function_exists('get_status_payments')) {
    function get_status_payments($key)
    {

        $types = [
            0 => 'Default',
            1 => 'Success',
            2 => 'Pending',
            3 => 'Hold',
            4 => 'Rejected',
        ];
        if ($key < 0 || $key > count($types)) {
            return 'N/A';
        }
        return $types[$key];
    }
}


function generatePaymentTXNCode(): string
{
    $length = 20;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $txn_code = substr(str_shuffle($characters), 0, $length);

    return $txn_code;
}
function hex2rgba($color, $opacity = false)
{
    return Colorcodeconverter::convertHexToRgba($color, $opacity);
}

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        if (Auth::check() && (is_admin())) {
            return true;
        }
        return false;
    }
}

if (!function_exists('isSeller')) {
    function isSeller()
    {
        if (Auth::check() && Auth::user()->user_type == 'seller') {
            return true;
        }
        return false;
    }
}

if (!function_exists('isCustomer')) {
    function isCustomer()
    {
        if (Auth::check() && Auth::user()->user_type == 'customer') {
            return true;
        }
        return false;
    }
}

if (!function_exists('isFactoryEmployee')) {
    function isFactoryEmployee()
    {
        if (Auth::check() && (Auth::user()->user_type == 'staff' && Auth::user()->staff->role->name != 'Factory employee')) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('isFactoryManager')) {
    function isFactoryManager()
    {
        if (Auth::check() && (Auth::user()->user_type == 'staff' && Auth::user()->staff->role->name != 'Factory manager')) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

// duplicates m$ excel's ceiling function
if (!function_exists('ceiling')) {
    function ceiling($number, $significance = 1)
    {
        return (is_numeric($number) && is_numeric($significance)) ? (ceil($number / $significance) * $significance) : false;
    }
}

if (!function_exists('get_images')) {
    function get_images($given_ids, $with_trashed = false)
    {
        $ids = is_array($given_ids)
            ? $given_ids
            : (is_null($given_ids) ? [] : explode(",", $given_ids));

        return $with_trashed
            ? Upload::withTrashed()->whereIn('id', $ids)->get()
            : Upload::whereIn('id', $ids)->get();
    }
}

//for api
if (!function_exists('get_images_path')) {
    function get_images_path($given_ids, $with_trashed = false)
    {
        $paths = [];
        $images = get_images($given_ids, $with_trashed);
        if (!$images->isEmpty()) {
            foreach ($images as $image) {
                $paths[] = !is_null($image) ? $image->file_name : "";
            }
        }

        return $paths;
    }
}

//for api
if (!function_exists('checkout_done')) {
    function checkout_done($order_id, $payment)
    {
        $order = Order::where('id', $order_id)->first();
        $order->payment_status = 'paid';
        $order->payment_details = $payment;
        $order->tenacy_id = get_tenacy_id_for_query();
        $order->save();

        if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {
            $affiliateController = new AffiliateController;
            $affiliateController->processAffiliatePoints($order);
        }

        if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated) {
            if (Auth::check()) {
                $clubpointController = new ClubPointController;
                $clubpointController->processClubPoints($order);
            }
        }
        $vendor_commission_activation = true;
        if (
            \App\Addon::where('unique_identifier', 'seller_subscription')->first() != null
            && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated
            && !get_setting('vendor_commission_activation')
        ) {
            $vendor_commission_activation = false;
        }

        if ($vendor_commission_activation) {
            if (BusinessSetting::where('type', 'category_wise_commission')->first()->value != 1) {
                $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $orderDetail->payment_status = 'paid';
                    $orderDetail->tenacy_id = get_tenacy_id_for_query();
                    $orderDetail->save();
                    if ($orderDetail->product->user->user_type == 'seller') {
                        $seller = $orderDetail->product->user->seller;
                        $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price * (100 - $commission_percentage)) / 100 + $orderDetail->tax + $orderDetail->shipping_cost;
                        $seller->tenacy_id = get_tenacy_id_for_query();
                        $seller->save();
                    }
                }
            } else {
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $orderDetail->payment_status = 'paid';
                    $orderDetail->tenacy_id = get_tenacy_id_for_query();
                    $orderDetail->save();
                    if ($orderDetail->product->user->user_type == 'seller') {
                        $commission_percentage = $orderDetail->product->category->commision_rate;
                        $seller = $orderDetail->product->user->seller;
                        $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price * (100 - $commission_percentage)) / 100 + $orderDetail->tax + $orderDetail->shipping_cost;
                        $seller->tenacy_id = get_tenacy_id_for_query();
                        $seller->save();
                    }
                }
            }
        } else {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->payment_status = 'paid';
                $orderDetail->tenacy_id = get_tenacy_id_for_query();
                $orderDetail->save();
                if ($orderDetail->product->user->user_type == 'seller') {
                    $seller = $orderDetail->product->user->seller;
                    $seller->admin_to_pay = $seller->admin_to_pay + $orderDetail->price + $orderDetail->tax + $orderDetail->shipping_cost;
                    $seller->tenacy_id = get_tenacy_id_for_query();
                    $seller->save();
                }
            }
        }

        $order->commission_calculated = 1;
        $order->tenacy_id = get_tenacy_id_for_query();
        $order->save();
    }
}

//for api
if (!function_exists('wallet_payment_done')) {
    function wallet_payment_done($user_id, $amount, $payment_method, $payment_details)
    {
        $user = \App\User::where('id', $user_id)->first();
        $user->balance = $user->balance + $amount;
        $user->tenacy_id = get_tenacy_id_for_query();
        $user->save();

        $wallet = new Wallet;
        $wallet->user_id = $user->id;
        $wallet->amount = $amount;
        $wallet->payment_method = $payment_method;
        $wallet->payment_details = $payment_details;
        $wallet->save();
    }
}

if (!function_exists('purchase_payment_done')) {
    function purchase_payment_done($user_id, $package_id)
    {
        $user = User::where('id', $user_id)->first();
        $user->customer_package_id = $package_id;
        $customer_package = CustomerPackage::where('id', $package_id)->first();
        $user->remaining_uploads += $customer_package->product_upload;
        $user->tenacy_id = get_tenacy_id_for_query();
        $user->save();

        return 'success';
    }
}

//Commission Calculation
if (!function_exists('commission_calculation')) {
    function commission_calculation($order)
    {
        $vendor_commission_activation = true;
        if (
            \App\Addon::where('unique_identifier', 'seller_subscription')->first() != null
            && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated
            && !get_setting('vendor_commission_activation')
        ) {
            $vendor_commission_activation = false;
        }

        if ($vendor_commission_activation) {
            if ($order->payment_type == 'cash_on_delivery') {
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $orderDetail->payment_status = 'paid';
                    $orderDetail->tenacy_id = get_tenacy_id_for_query();
                    $orderDetail->save();
                    $commission_percentage = 0;
                    if (get_setting('category_wise_commission') != 1) {
                        $commission_percentage = get_setting('vendor_commission');
                    } else if ($orderDetail->product->user->user_type == 'seller') {
                        $commission_percentage = $orderDetail->product->category->commision_rate;
                    }
                    if ($orderDetail->product->user->user_type == 'seller') {
                        $seller = $orderDetail->product->user->seller;
                        $admin_commission = ($orderDetail->price * $commission_percentage) / 100;

                        if (get_setting('product_manage_by_admin') == 1) {
                            $seller_earning = ($orderDetail->tax + $orderDetail->price) - $admin_commission;
                            $seller->admin_to_pay += $seller_earning;
                        } else {
                            $seller_earning = ($orderDetail->tax + $orderDetail->shipping_cost + $orderDetail->price) - $admin_commission;
                            $seller->admin_to_pay = $seller->admin_to_pay - $admin_commission;
                        }

                        $seller->tenacy_id = get_tenacy_id_for_query();
                        $seller->save();

                        $commission_history = new CommissionHistory;
                        $commission_history->order_id = $order->id;
                        $commission_history->order_detail_id = $orderDetail->id;
                        $commission_history->seller_id = $orderDetail->seller_id;
                        $commission_history->admin_commission = $admin_commission;
                        $commission_history->seller_earning = $seller_earning;

                        $commission_history->tenacy_id = get_tenacy_id_for_query();
                        $commission_history->save();
                    }
                }
            } elseif ($order->manual_payment) {
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $orderDetail->payment_status = 'paid';
                    $orderDetail->tenacy_id = get_tenacy_id_for_query();
                    $orderDetail->save();
                    $commission_percentage = 0;
                    if (get_setting('category_wise_commission') != 1) {
                        $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
                    } else if ($orderDetail->product->user->user_type == 'seller') {
                        $commission_percentage = $orderDetail->product->category->commision_rate;
                    }
                    if ($orderDetail->product->user->user_type == 'seller') {
                        $seller = $orderDetail->product->user->seller;
                        $admin_commission = ($orderDetail->price * $commission_percentage) / 100;

                        if (get_setting('product_manage_by_admin') == 1) {
                            $seller_earning = ($orderDetail->tax + $orderDetail->price) - $admin_commission;
                            $seller->admin_to_pay += $seller_earning;
                        } else {
                            $seller_earning = ($orderDetail->tax + $orderDetail->shipping_cost + $orderDetail->price) - $admin_commission;
                            $seller->admin_to_pay += $seller_earning;
                        }

                        $seller->tenacy_id = get_tenacy_id_for_query();
                        $seller->save();

                        $commission_history = new CommissionHistory;
                        $commission_history->order_id = $order->id;
                        $commission_history->order_detail_id = $orderDetail->id;
                        $commission_history->seller_id = $orderDetail->seller_id;
                        $commission_history->admin_commission = $admin_commission;
                        $commission_history->seller_earning = $seller_earning;

                        $commission_history->tenacy_id = get_tenacy_id_for_query();
                        $commission_history->save();
                    }
                }
            }
        }

        if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {
            $affiliateController = new AffiliateController;
            $affiliateController->processAffiliatePoints($order);
        }

        if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated) {
            if ($order->user != null) {
                $clubpointController = new ClubPointController;
                $clubpointController->processClubPoints($order);
            }
        }
    }
}

if (!function_exists('get_tenacy_id_for_query')) {
    function get_tenacy_id_for_query()
    {
        $tenant = \App\Models\Tenant::where('host_id', Auth::id())->where('is_deleted', 0)->first();
        if ($tenant) {
            return $tenant->code;
        } else {
            return 'all';
        }
    }
}

if (!function_exists('is_main_tenacy')) {
    function is_main_tenacy()
    {
        if (env('IS_MAIN_TENACY') && env('IS_MAIN_TENACY') == 'true') {
            return true;
        }
        return false;
    }
}

if (!function_exists('get_tenacy_id')) {
    function get_tenacy_id()
    {
        if (!empty(env('TENACY_ID'))) {
            return env('TENACY_ID');
        }
        return null;
    }
}

if (!function_exists('get_tenacy_file_path')) {
    function get_tenacy_file_path()
    {
        if (!empty(env('TENACY_ID'))) {
            return env('TENACY_ID') . '/';
        }
        return '';
    }
}

//return file uploaded via uploader
// if (!function_exists('uploaded_asset_logo')) {
//     function uploaded_asset_logo($id)
//     {
//         if (($asset = \App\Upload::find($id)) != null) {
//             return my_asset($asset->file_name);
//         }
//         return static_asset('assets/img/logo.png');
//     }
// }

function un_number_format($number)
{
    $number = str_replace(',', '', $number);
    return $number;
}

function response_json($status, $msg, $data = [])
{
    return response()->json([
        'status' => $status,
        'msg' => $msg,
        'data' => $data,
    ]);
}

function stripVN($str)
{
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);

    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    return $str;
}

function cleanString($text)
{
    $utf8 = array(
        '/[áàâãªä]/u'   =>   'a',
        '/[ÁÀÂÃÄ]/u'    =>   'A',
        '/[ÍÌÎÏ]/u'     =>   'I',
        '/[íìîï]/u'     =>   'i',
        '/[éèêë]/u'     =>   'e',
        '/[ÉÈÊË]/u'     =>   'E',
        '/[óòôõºö]/u'   =>   'o',
        '/[ÓÒÔÕÖ]/u'    =>   'O',
        '/[úùûü]/u'     =>   'u',
        '/[ÚÙÛÜ]/u'     =>   'U',
        '/ç/'           =>   'c',
        '/Ç/'           =>   'C',
        '/ñ/'           =>   'n',
        '/Ñ/'           =>   'N',
        '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
        '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
        '/[“”«»„]/u'    =>   ' ', // Double quote
        '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
    );
    return preg_replace(array_keys($utf8), array_values($utf8), $text);
}

function generateRandomString($length = 10)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function format_date($date)
{
    return date('d/m/Y', strtotime($date));
}

function format_date_time($date)
{
    return date('H:i d/m/Y', strtotime($date));
}

function getTempUserId()
{
    $session = \Illuminate\Support\Facades\Request::session();
    $tempUserId = '';

    if (!auth()->check()) {
        if($session->get('temp_user_id')) {
            $tempUserId = $session->get('temp_user_id');
        } else {
            $tempUserId = bin2hex(random_bytes(10));
            $session->put('temp_user_id', $tempUserId);
        }
    }
    return $tempUserId;
}
function is_super_admin(): bool
{
    if (Auth::check() && (Auth::user()->user_type == 'admin')) {
        return true;
    } else {
        return false;
    }
}
function is_admin(): bool
{
    if(Auth::check() && (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff' || Auth::user()->user_type == 'host')) {
        return true;
    } else {
        return false;
    }
}
function is_host(): bool
{
    if (Auth::check() && (Auth::user()->user_type == 'host')) {
        return true;
    } else {
        return false;
    }
}
function is_host_staff(): bool
{
    if (Auth::check() && (Auth::user()->user_type == 'host_staff')) {
        return true;
    } else {
        return false;
    }
}
function is_using_tenacy_id(): bool
{
    if (Auth::check() && (Auth::user()->user_type == 'host_staff' || Auth::user()->user_type == 'host')) {
        return true;
    } else {
        return false;
    }
}
function user_types(): array
{
    if(is_host()) {
        return [
            'host_staff' => 'Nhân viên xưởng',
        ];
    }
    return [
        'staff' => 'Nhân viên',
        'host' => 'Quản lý xưởng',
        'host_staff' => 'Nhân viên xưởng',
    ];
}
function roleNameCanNotDelete(): array
{
    return [
        "Quản lý xưởng",
    ];
}
?>
