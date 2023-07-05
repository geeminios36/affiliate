<?php

namespace App\Http\Controllers;

use App\EcommerceMarketPlace;
use App\Http\Traits\MarketPlaceTrait;
use App\LazadaLib\lazop\LazopClient;
use App\LazadaLib\lazop\LazopRequest;
use App\LazadaLib\lazop\UrlConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LazadaController extends Controller
{
    //
    public function __construct()
    {

    }

    public function connect(Request $request)
    {
        $code = $request->code;
        $appkey = config('market_place.lazada.client_id');
        $app_secret = config('market_place.lazada.secret_key');

        $client = new LazopClient(UrlConstants::$api_authorization_url, $appkey, $app_secret);
        $request = new LazopRequest(config('market_place.lazada.create_token'));
        $request->addApiParam('code', $code);
        $response = $client->execute($request);
        $responseDecode = json_decode($response);
        $accessToken = $responseDecode->access_token;
        $sellerId = $responseDecode->country_user_info[0]->seller_id;
        $insert = [
            'connection_info' => $response,
            'market_id' => $sellerId,
            'token' => $accessToken,
            'market_type' => 3,
            'status' => 1,
            'logo' => config('market_place.lazada.logo'),
            'created_by' => Auth::user()->id,
        ];

        $ecommerceMarketPlace = EcommerceMarketPlace::updateOrCreate(['market_id' => $sellerId], $insert);

        return redirect()->to(route('market_place.config_market', $ecommerceMarketPlace->id) . '?name=' . $responseDecode->account);
    }

}
