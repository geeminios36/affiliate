<?php

namespace App\Http\Repository;

use App\BusinessSetting;
use App\EcommerceMarketPlace;
use App\EcommerceMarketPlaceConfig;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EcommerceMarketPlaceConfigRepository
{
    public function __construct()
    {
        $this->model = new EcommerceMarketPlaceConfig();
    }

    public function createConfigById($ecommerceMarketPlaceId, $inputData, $name = '')
    {
        $insertData = [
            'ecommerce_market_place_id' => $ecommerceMarketPlaceId,
            'shorted_name' => empty(@$inputData['shortenedName']) ? $name : $inputData['shortenedName'],
            'tenacy_id' => env('TENACY_ID'),
            'order_officer' => Auth::user()->id,
        ];

        return $this->model->updateOrCreate([
            'ecommerce_market_place_id' => $ecommerceMarketPlaceId,
            'tenacy_id' => env('TENACY_ID'),
        ], $insertData);
    }

}
