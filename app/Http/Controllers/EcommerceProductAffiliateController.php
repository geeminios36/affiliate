<?php

namespace App\Http\Controllers;

use App\EcommerceLinkProducts;
use App\Http\Repository\EcommerceLinkProductRepository;
use App\Http\Repository\EcommerceMarketPlaceConfigRepository;
use App\Http\Repository\EcommerceMarketPlacesRepository;
use App\Http\Repository\lazadaRepsitory;
use App\Http\Repository\TikiRepository;
use App\Http\Repository\ProductRepository;
use App\Http\Repository\ProductStockRepository;
use App\Http\Traits\MarketPlaceTrait;
use App\Jobs\LinkAllProductLazadaById;
use App\Jobs\LinkAllProductTikiById;
use App\Jobs\SyncAllProduct;
use App\Jobs\LinkAllProductById;
use App\LazadaLib\lazop\LazopClient;
use App\LazadaLib\lazop\LazopRequest;
use App\LazadaLib\lazop\UrlConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EcommerceProductAffiliateController extends Controller
{
    //
    /**
     * @var EcommerceMarketPlaceConfigRepository
     */
    private $repEcommerceMarketPlaceConfig;
    /**
     * @var EcommerceMarketPlacesRepository
     */
    private $repEcommerceMarketPlace;
    /**
     * @var ProductRepository
     */
    private $repProduct;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $sendoType;

    public function __construct()
    {
        $this->repEcommerceMarketPlaceConfig = new EcommerceMarketPlaceConfigRepository();
        $this->repEcommerceMarketPlace = new EcommerceMarketPlacesRepository();
        $this->repEcommerceLinkProduct = new EcommerceLinkProductRepository();
        $this->repProduct = new ProductRepository();
        $this->repProductStock = new ProductStockRepository();
        $this->repLazada = new lazadaRepsitory();
        $this->repTiki= new TikiRepository();
        $this->sendoType = config('market_place.market_key.sendo');
        $this->lazadaType = config('market_place.market_key.lazada');
        $this->tikiType = config('market_place.market_key.tiki');
    }

    public function index()
    {
        $sendoMarket = $this->repEcommerceMarketPlace->getConnectionSendo();
        $msg = [];
        if (count($sendoMarket)) {
            $url = config('market_place.sendo.product_info_by_sku');
            foreach ($sendoMarket as $sendoMarketInfo) {
                $checkkLoginSendo = MarketPlaceTrait::curlAPI($url, $sendoMarketInfo->token, []);
                if (isset(json_decode($checkkLoginSendo)->exp) && json_decode($checkkLoginSendo)->exp == 'token expired')
                    $msg[] = "Vui lòng đăng nhập lại Sendo";
            }
        }

        $msg = implode('', array_unique($msg));

        return view('backend.market-place.product_affiliate.index', compact('msg'));
    }

    public function listDataProduct(Request $request)
    {
        $inputData = $request->all();
        $productStockId = @$inputData['product_stock_id'];
        $keyword = @$inputData['keyword'];
        $page = @$inputData['page'];
        $productStocks = $this->repProduct->getPaginateProductStock($inputData, $page);
        $connectedMarket = $this->repEcommerceMarketPlace->getAllConnectedMarket();
        return view('backend.market-place.product_affiliate.list_data_product', compact('productStocks', 'connectedMarket', 'productStockId', 'keyword', 'page'));
    }

    public function dataProductFilter(Request $request)
    {
        $inputData = $request->all();
        $page = @$inputData['page'];
        $productStocks = $this->repProduct->getPaginateProductStock($inputData, $page);
        $connectedMarket = $this->repEcommerceMarketPlace->getAllConnectedMarket();

        return response()->json([
            'status' => true,
            'view' => view('backend.market-place.product_affiliate.data_filter', compact('productStocks', 'connectedMarket'))->render(),
        ]);

    }

    /**
     * @param Request $request
     * @param $marketPlaceId
     * @param null $productStockId
     * $productStockId = null ? link all product which has sku like market product's sku  : $productStockId
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function linkProduct(Request $request, $productStockId = null, $marketPlaceId = null)
    {
        $productStockInfo = null;
        if (!empty($productStockId)) {
            $productStockInfo = $this->repProductStock->getProductStockById($productStockId);
            if (empty($productStockInfo)) {
                return response_json(false, 'Không tồn tại sản phẩm');
            }
        }

        if (!empty($marketPlaceId) && !empty($productStockInfo)) {
            $marketPlaceInfo = $this->repEcommerceMarketPlace->getMarketById($marketPlaceId);
            if (empty($marketPlaceInfo)) {
                return response_json(false, 'Sàn thương mại chưa được kết nối');
            }

            return self::checkExistAndLinkedProduct($marketPlaceInfo, $productStockInfo);
        }

        if (empty($marketPlaceId) && !empty($productStockInfo)) {
            return self::checkExistAndLinkedAllMarket($productStockInfo);
        }

        return [];
    }

    private function checkExistAndLinkedAllMarket($productStockInfo)
    {
        $marketPlaces = $this->repEcommerceMarketPlace->getAllConnectedMarket();
        $url = config('market_place.sendo.product_info_by_sku') . $productStockInfo->sku;
        $checkSyncProduct = [];
        $massage = '';
        foreach ($marketPlaces as $marketPlaceInfo) {
            if ($marketPlaceInfo->market_type == $this->sendoType) {
                $synced = self::checkExistAndLinkedSendo($url, $marketPlaceInfo->token, $marketPlaceInfo->id, $productStockInfo);
                $checkSyncProduct[] = $synced;
                $massage .= $synced->original['msg'] . '. ';
            } elseif ($marketPlaceInfo->market_type == $this->lazadaType) {
                $synced = $this->repLazada->linkProduct($marketPlaceInfo, $productStockInfo);
                $checkSyncProduct[] = $synced;
            }
        }
        $checkSynced = collect($checkSyncProduct)->pluck('original')->pluck('status')->contains(true);

        if ($checkSynced) {
            return response_json(true, !empty($massage) ? $massage : ' Đồng bộ sản phẩm thành công');
        }

        return response_json(false, !empty($massage) ? $massage : 'Đồng bộ sản phẩm không thành công');
    }

    /**
     * @param $productStockInfo
     */
    private function checkExistAndLinkedProduct($marketPlaceInfo, $productStockInfo)
    {
        if ($marketPlaceInfo->market_type == $this->sendoType) {
            $url = config('market_place.sendo.product_info_by_sku') . $productStockInfo->sku;
            return self::checkExistAndLinkedSendo($url, $marketPlaceInfo->token, $marketPlaceInfo->id, $productStockInfo);
        } elseif ($marketPlaceInfo->market_type == $this->lazadaType) {
            return $this->repLazada->linkProduct($marketPlaceInfo, $productStockInfo);
        } elseif ($marketPlaceInfo->market_type == $this->tikiType) {
            return $this->repTiki->linkProduct($marketPlaceInfo, $productStockInfo);
        }

        return [];

    }

    /**
     * @param $url
     * @param $token
     * @return \Illuminate\Http\JsonResponse|void
     */
    private function checkExistAndLinkedSendo($url, $token, $marketPlaceId, $productStockInfo)
    {
        $productInMarket = MarketPlaceTrait::curlAPI($url, $token, [], 'GET');
        $productInMarket = json_decode($productInMarket);

        if (empty($productInMarket)) {
            return response_json(false, 'Không tìm thấy mã sku này tại đơn vị');
        }

        if ($productInMarket->status_code == 400) {
            return response_json(false, $productInMarket->error->message);
        }

        if (in_array($productInMarket->result->status, [1, 4, 5])) {
            return response_json(false, 'Sản phẩm đang chờ duyệt hoặc đã bị xóa');
        }

        $idProductConnecting = $productInMarket->result->id;

        $urlUpdateProduct = config('market_place.sendo.update_or_create_product');

        $data = [
            'id' => $idProductConnecting,
            'token' => $token,
            'url' => $urlUpdateProduct,
            'ecommerce_market_place_d' => $marketPlaceId,
            'product_in_market' => $productInMarket,
            'product_current' => $productStockInfo
        ];

        return $this->repEcommerceLinkProduct->linkOneProductToMarket($data);
    }

    public function linkMultiProducts(Request $request)
    {
        $inputData = $request->all();

        $marketPlaceId = $inputData['market_place_id'];
        $keyCache = 'market_place_' . $marketPlaceId;
        $marketPlaceInfo = Cache::remember($keyCache, 300, function () use ($marketPlaceId) {
            return $this->repEcommerceMarketPlace->getMarketById($marketPlaceId);
        });

        if ($inputData['all'] == 'false') {
            $productStockIds = array_map(function ($id) {
                    return (int)$id;
            }, $inputData['product_stock_id']);

            $productStockIdsSynced = $this->repEcommerceLinkProduct->getProductStockIdsIsSynced($marketPlaceId);
            $productStockIds = array_diff($productStockIds, $productStockIdsSynced);

            if (count($productStockIds)) {
                $this->syncDataByMarket($marketPlaceInfo, $productStockIds);
            }

            return response_json('true', 'Syncing');
        } else {
            $this->syncDataByMarket($marketPlaceInfo);

            return response_json('true', 'Syncing');
        }

        return response_json(true, 'Sản phẩm chưa có tại cửa hàng');
    }

    private function syncDataByMarket($marketPlaceInfo, $productStockIds = []){
        if ($marketPlaceInfo->market_type == config('market_place.market_key.sendo')) {
            LinkAllProductById::dispatch($productStockIds, $marketPlaceInfo);
        } elseif ($marketPlaceInfo->market_type == config('market_place.market_key.lazada')) {
            LinkAllProductLazadaById::dispatch($productStockIds, $marketPlaceInfo);
        } elseif ($marketPlaceInfo->market_type == config('market_place.market_key.tiki')) {
            LinkAllProductTikiById::dispatch($productStockIds, $marketPlaceInfo);
        }
    }

    public function disconnectProduct(Request $request, $productLinkedId = null, $marketPlaceId = null)
    {
        $productLinkedId = is_numeric($productLinkedId) ? $productLinkedId : json_decode($productLinkedId);
        if (!empty($marketPlaceId) && !empty($productLinkedId)) {
            $marketPlaceInfo = $this->repEcommerceMarketPlace->getMarketById($marketPlaceId);
            if (empty($marketPlaceInfo)) {
                return response_json(false, 'Sản thương mại chưa được kết nối');
            }

            if (is_array($productLinkedId)) {
                $productLinkedIds = $this->repEcommerceLinkProduct->getLinkProductsIds($productLinkedId, $marketPlaceId);
                if (!count($productLinkedIds)) {
                    return response_json(false, 'Sản phẩm chưa được liên kết');
                }

                EcommerceLinkProducts::whereIn('id', $productLinkedIds)->update(['is_deleted' => 1]);
            } else {
                $productLinkedInfo = $this->repEcommerceLinkProduct->getLinkProductById($productLinkedId);
                if (empty($productLinkedInfo)) {
                    return response_json(false, 'Sản phẩm chưa được liên kết');
                }

                $productLinkedInfo->update(['is_deleted' => 1]);
            }


            return response_json(true, 'Hủy liên kết sản phẩm thành công');
        } elseif (empty($marketPlaceId) && !empty($productLinkedId)) {
            $marketPlaceInfo = EcommerceLinkProducts::where('product_stock_id', $productLinkedId)->update(['is_deleted' => 1]);
            if (!empty($marketPlaceInfo)) {
                return response_json(true, 'Hủy liên kết sản phẩm thành công');
            }

            return response_json(true, 'Có lỗi xảy ra');
        }
    }

    public function syncing()
    {
        SyncAllProduct::dispatch();
        return response_json(true, 'Sản phẩm đang được đồng bộ');
    }
}
