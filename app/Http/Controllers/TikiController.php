<?php

namespace App\Http\Controllers;

use App\EcommerceMarketPlace;
use App\Http\Traits\MarketPlaceTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TikiController extends Controller
{
    //
    public function __construct()
    {
        $this->redirectUrl = route('market_place.tiki.connect');
        $this->tikiClientId = config('market_place.tiki.client_id');
        $this->tikiSecretKey = config('market_place.tiki.secret_key');
        $this->tikiScope = config('market_place.tiki.scope');
        $this->tikiToken = config('market_place.tiki.access_token');
        $this->tikiInfo = config('market_place.tiki.information');
    }

    public function connect(Request $request)
    {
        $inputData = $request->all();
        if (isset($inputData['code']) && isset($inputData['scope'])) {
            $Auth_Key = $this->tikiClientId . ":" . $this->tikiSecretKey;
            $encoded_Auth_Key = base64_encode($Auth_Key);

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->tikiToken,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'grant_type=authorization_code&code=' . $inputData['code'] . '&redirect_uri=' . $this->redirectUrl . '&client_id=' . $this->tikiClientId,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic ' . $encoded_Auth_Key,
                    'Content-Type: application/x-www-form-urlencoded',
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $response = json_decode($response);

            $shopInfo = MarketPlaceTrait::curlAPI($this->tikiInfo, $response->access_token, [], 'GET');
            $shopInfo = json_decode($shopInfo);
            $insert = [
                'connection_info' => json_encode($response),
                'market_id' => $shopInfo->sid,
                'token' => $response->access_token,
                'market_type' => 1,
                'status' => 1,
                'logo' => '/assets/img/market_place/tiki.png',
                'created_by' => Auth::user()->id,
            ];

            $ecommerceMarketPlace = EcommerceMarketPlace::updateOrCreate(['market_id' => $shopInfo->sid], $insert);

            return redirect()->to(route('market_place.config_market', $ecommerceMarketPlace->id) . '?name=' . $shopInfo->name);
        }
    }

}
