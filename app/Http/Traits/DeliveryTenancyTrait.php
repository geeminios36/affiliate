<?php

namespace App\Http\Traits;

use App\DeliveryTenancies;
use function GuzzleHttp\json_decode;

trait DeliveryTenancyTrait
{
    public static function getDeliveryTenancyById($delivery_tenancies_id)
    {
        return DeliveryTenancies::whereId($delivery_tenancies_id)
            ->withAndWhereHas('delivery_partners', function () {

            })
            ->first();
    }

    public static function getShopInfo($delivery_tenancies_id)
    {
        $delivery_tenancy = DeliveryTenancies::find($delivery_tenancies_id);
        $shopConfig = config('api_delivery_partner.' . $delivery_tenancy->delivery_partners->code . '.shop');

        $shop = DeliveryTenancyTrait::cURLApi($delivery_tenancy['token_key'], $shopConfig, 'GET');
        $shop = json_decode($shop);

        if (isset($shop->code) && $shop->code == 200) {
            $shop = collect($shop->data->shops)
                ->where('_id', $delivery_tenancy['connect_partner_id'])
                ->first();
        } elseif (isset($shop->success) && $shop->success) {
            $shop = collect($shop->data)
                ->where('pick_address_id', $delivery_tenancy['connect_partner_id'])
                ->first();
            $shop->address = empty($shop->address) ? [] : explode(', ', $shop->address);
        } else {
            return response_json(false, 'Không tồn tại cửa hàng tại đơn vị này');
        }

        return $shop;
    }

    public static function cURLApi($token, $config, $method = null, $data = [], $shopId = null, $code = null)
    {
        $curl = curl_init();
        $header = [
            "content-type: application/json",
        ];
        if (!empty($token)){
            $header = [
                "content-type: application/json",
                "Token: " . $token,
            ];
        };

        if (!empty($shopId)) {
            $header = array_merge($header, ["ShopId: " . $shopId]);
        }

        if ($code == config('constants.ghtk')){
            $header = array_merge($header, ["Content-Length: " . strlen($data)]);
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => $config,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => empty($method) ? 'POST' : $method,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => $code == config('constants.ghtk') ? $data : (count($data) ? json_encode($data) : []),
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public static function getProvinces($full = false)
    {
        $curl = curl_init();
        $header = [
            "content-type: application/json",
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => $full ? config('constants.api_provinces_full') : config('constants.api_provinces'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => [],
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
