<?php

namespace App\Http\Controllers;

use App\EcommerceMarketPlace;
use App\Http\Repository\EcommerceMarketPlaceConfigRepository;
use App\Http\Repository\EcommerceMarketPlacesRepository;
use App\Http\Repository\UserRepository;
use App\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EcommerceMarketPlaceController extends Controller
{
    //
    /**
     * @var string
     */
    private $redirectUrl;
    /**
     * @var string
     */
    private $tikiClientId;
    /**
     * @var string
     */
    private $tikiScope;
    /**
     * @var string[]
     */
    private $connectOther;

    public function __construct()
    {
        $this->repEcommerceMarketPlaceConfig = new EcommerceMarketPlaceConfigRepository();
        $this->repEcommerceMarketPlace = new EcommerceMarketPlacesRepository();
        $this->repUser = new UserRepository();
        $this->redirectTikiUrl = route('market_place.tiki.connect');
        $this->tikiClientId = config('market_place.tiki.client_id');
        $this->tikiScope = config('market_place.tiki.scope');
        $this->redirectLazadaUrl = route('market_place.lazada.connect');
        $this->lazadaClientId = config('market_place.lazada.client_id');
        $this->connectOther = [
            'tiki' => config('market_place.tiki.login') . $this->tikiClientId . '&redirect_uri=' . $this->redirectTikiUrl . '&scope=' . $this->tikiScope . '&state=RJvROw5fL',
            'lazada' => config('market_place.lazada.login') . '&response_type=code&force_auth=true&redirect_uri=' . $this->redirectLazadaUrl . '&client_id=' . $this->lazadaClientId,
        ];
    }

    public function index()
    {
        $connectedMarket = EcommerceMarketPlace::where('tenacy_id', env('TENACY_ID'))
            ->where('status', 1)
            ->get();

        return view('backend.market-place.index', compact('connectedMarket'));
    }


    public function connect()
    {
        $connectOther = $this->connectOther;

        return view('backend.market-place.connect', compact('connectOther'));
    }

    public function generalPage()
    {
        $connectOther = $this->connectOther;
        $connectedMarket = $this->repEcommerceMarketPlace->getAllMarket();
        $productCurrent = ProductStock::whereNotNull('sku')
            ->withAndWhereHas('product', function ($q) {
            })->get();

        foreach ($connectedMarket as $connectedMarketInfo) {
            $token = $connectedMarketInfo->token;
            $type_market = config('market_place.type_market')[$connectedMarketInfo->market_type];
            if ($connectedMarketInfo->market_type == config('market_place.market_key.sendo')) {
//                $listOrders = $this->repEcommerceMarketPlace->getSendoOrderList($connectedMarketInfo, $token, $type_market);
                $listProducts = $this->repEcommerceMarketPlace->getSendoProductList($token, $type_market);
                if (isset($listProducts['status']) && !$listProducts['status']) {
                    $connectedMarketInfo->status = 2; //token exp
                }
            }

            $connectedMarketInfo->connectProductCount = $connectedMarketInfo->ecommerce_link_products->count();
            $connectedMarketInfo->connectOrderCount = 0;

        }

        $orderToday = DB::table('orders')->count();

        return view('backend.market-place.connected_page.general', compact('connectedMarket', 'connectOther', 'productCurrent', 'orderToday'));
    }

    public function configMarket($ecommerceMarketPlaceId = null)
    {
        return view('backend.market-place.connected_page.config_market', compact('ecommerceMarketPlaceId'));
    }

    public function customConfig(Request $request, $ecommerceMarketPlaceId = null)
    {
        $inputData = $request->all();
        $ecommerceMarketPlace = $this->repEcommerceMarketPlace->getMarketById($ecommerceMarketPlaceId);
        if (empty($ecommerceMarketPlace)) {
            return response_json(false, 'Không tồn tại kết nối này');
        }

        $shopKey = $secretKey = $config = $staffId = '';
        if ($ecommerceMarketPlace->market_type == config('market_place.market_key.sendo')) {
            $config = $this->repEcommerceMarketPlaceConfig->createConfigById($ecommerceMarketPlaceId, $inputData);
            if (empty($config)) {
                return response_json(false, 'Có lỗi trong quá trình cài đặt');
            }

            $connection_info = json_decode($ecommerceMarketPlace->connection_info);
            $shopKey = @$connection_info->shop_key;
            $secretKey = @$connection_info->secret_key;
            $staffId = @$config->order_officer;
        } elseif ($ecommerceMarketPlace->market_type == config('market_place.market_key.tiki')){

        }

        $employees = $this->repUser->getStaff();

        return view('backend.market-place.connected_page.config_market.custom_config', compact('ecommerceMarketPlaceId',
            'secretKey',
            'shopKey',
            'ecommerceMarketPlace',
            'config',
            'employees',
            'staffId'
        ));
    }

    public function saveConfig(Request $request, $ecommerceMarketPlaceId = null)
    {
        $inputData = $request->all();
        if ($inputData['custom'] == 'false') {
            $config = $this->repEcommerceMarketPlaceConfig->createConfigById($ecommerceMarketPlaceId, $inputData);
            if ($config) {
                return response_json(true, 'Cấu hình cài đặt');
            }

            return response_json(false, 'Có lỗi trong quá trình cài đặt');

        } else {
            $config = $this->repEcommerceMarketPlaceConfig->createConfigById($ecommerceMarketPlaceId, $inputData);
            if ($config) {
                return response_json(true, 'Cấu hình cài đặt');
            }

            return response_json(false, 'Có lỗi trong quá trình cài đặt');
        }
    }

    public function configMarketData($ecommerceMarketPlaceId = null)
    {
        if (empty($ecommerceMarketPlaceId)) {
            $ecommerceMarketPlaces = $this->repEcommerceMarketPlace->getAllMarket();
            $ecommerceMarketPlacesGroupType = $ecommerceMarketPlaces->groupBy('market_type');
            return view('backend.market-place.connected_page.config_market.general_config', compact('ecommerceMarketPlaces', 'ecommerceMarketPlacesGroupType'));
        }

        $ecommerceMarketPlace = EcommerceMarketPlace::where('status', 1)
            ->whereId($ecommerceMarketPlaceId)
            ->first();
        $shortenedName = '';

        if (!empty($ecommerceMarketPlace) && @$ecommerceMarketPlace->market_type == config('market_place.market_key.sendo')) {
            $token = $ecommerceMarketPlace->token;
            $shortenedName = config('market_place.type_market')[$ecommerceMarketPlace->market_type];
        }

        $view = view('backend.market-place.connected_page.config_market.first_config', compact('ecommerceMarketPlace', 'shortenedName'));

        if (empty($ecommerceMarketPlace)) {
            echo '<script>window.top.location.href = "' . route('market_place.index') . '"</script>';
            die();
        }

        return $view;
    }
}
