<?php

namespace App\Http\Controllers;

use App\EcommerceMarketPlace;
use App\Http\Repository\EcommerceMarketPlaceConfigRepository;
use App\Http\Repository\EcommerceMarketPlacesRepository;
use App\Http\Requests\LoginSendoRequest;
use App\Http\Traits\MarketPlaceTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SendoController extends Controller
{
    public function __construct()
    {
        $this->repEcommerceMarketPlace = new EcommerceMarketPlacesRepository();
        $this->repEcommerceMarketPlaceConfig = new EcommerceMarketPlaceConfigRepository();
    }

    public function connect()
    {
        return view('backend.market-place.sendo.connect');
    }

    public function connecting(LoginSendoRequest $request)
    {
        $inputData = $request->all();
        $data = [
            'shop_key' => $inputData['shop_key'],
            'secret_key' => $inputData['secret_key'],
        ];

        $checkExistConnected = $this->repEcommerceMarketPlace->getConnectionSendo();
        $checkExistConnected = $checkExistConnected->filter(function ($query) use ($inputData) {
            return @$inputData['secret_key'] == json_decode($query->connection_info)->secret_key;
        });

        $response = $this->getInfoConnection($data);
        if (isset($response->success) && $response->success) {
            $insert = [
                'connection_info' => json_encode($data),
                'token' => $response->result->token,
                'market_type' => config('market_place.market_key.sendo'),
                'status' => 1,
                'created_by' => Auth::user()->id,
                'logo' => '/assets/img/market_place/sendo.png',
            ];

            $id = count($checkExistConnected) ? $checkExistConnected->first()->id : '';

            $ecommerceMarketPlace = EcommerceMarketPlace::updateOrCreate(['id' => $id], $insert);

            $name = config('market_place.type_market')[$ecommerceMarketPlace->market_type];
            $this->repEcommerceMarketPlaceConfig->createConfigById($ecommerceMarketPlace->id, $inputData, $name);

            return response_json(true, 'Kết nối thành công', ['id' => $ecommerceMarketPlace->id, 'count' => count($checkExistConnected) ? true : false]);
        }

        return response_json(false, 'Tài khoản không tồn tại');

    }

    public function getInfoConnection($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => config('market_place.sendo.login'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response);

        return $response;
    }
}
