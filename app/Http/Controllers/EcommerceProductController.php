<?php

namespace App\Http\Controllers;

use App\EcommerceLinkProducts;
use App\Http\Repository\EcommerceLinkProductRepository;
use App\Http\Repository\EcommerceMarketPlaceConfigRepository;
use App\Http\Repository\EcommerceMarketPlacesRepository;
use App\Http\Repository\lazadaRepsitory;
use App\Http\Repository\ProductRepository;
use App\Http\Repository\ProductStockRepository;
use App\Http\Repository\SendoRepository;
use App\Http\Requests\LinkProductRequest;
use App\Http\Traits\MarketPlaceTrait;
use App\Jobs\LinkAllProductTikiById;
use App\Jobs\LinkProductInLazadaToSystem;
use App\Jobs\LinkProductInSendoToSystem;
use App\Jobs\SyncAllProductInMarket;
use App\LazadaLib\lazop\LazopClient;
use App\LazadaLib\lazop\LazopRequest;
use App\LazadaLib\lazop\UrlConstants;
use App\Product;
use App\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class EcommerceProductController extends Controller
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
     * @var lazadaRepsitory
     */
    private $repLazada;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $sendoType;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $lazadaType;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $tikiType;
    /**
     * @var SendoRepository
     */
    private $repSendo;

    public function __construct()
    {
        $this->repEcommerceMarketPlaceConfig = new EcommerceMarketPlaceConfigRepository();
        $this->repEcommerceMarketPlace = new EcommerceMarketPlacesRepository();
        $this->repEcommerceLinkProduct = new EcommerceLinkProductRepository();
        $this->repProductStock = new ProductStockRepository();
        $this->repLazada = new lazadaRepsitory();
        $this->repSendo = new SendoRepository();
        $this->repProduct = new ProductRepository();
        $this->sendoType = config('market_place.market_key.sendo');
        $this->lazadaType = config('market_place.market_key.lazada');
        $this->tikiType = config('market_place.market_key.tiki');
    }

    public function index()
    {
        return view('backend.market-place.product.index');
    }

    public function listData()
    {
        $connectedMarket = $this->repEcommerceMarketPlace->getAllConnectedMarket();
        return view('backend.market-place.product.list_data', compact('connectedMarket'));
    }

    public function listDataProduct(Request $request)
    {
        $inputData = $request->all();
        $marketId = isset($inputData['market']) ? $inputData['market'] : [];
        $connectedMarket = $this->repEcommerceMarketPlace->getAllConnectedMarketByIds($marketId);

        $products = [];
        $name = [];
        foreach ($connectedMarket as $connectedMarketInfo) {
            $token = $connectedMarketInfo->token;
            $ecommerceLinkProducts = $connectedMarketInfo->ecommerce_link_products;
            $type_market = config('market_place.type_market')[$connectedMarketInfo->market_type];
            if ($connectedMarketInfo->market_type == config('market_place.market_key.sendo')) {
                $listProducts = $this->repEcommerceMarketPlace->getSendoProductList($token, $type_market, true);
                if (!isset($listProducts['status'])) {
                    $listProducts = $listProducts->map(function ($q) use ($ecommerceLinkProducts, $inputData) {
                        $q->item_id = $q->id;
                        $checkSynced = count($ecommerceLinkProducts->where('parent_product_market_place_id', $q->id));
                        if (!empty($inputData['type'])) {
                            if ($inputData['type'] == 1 ? $checkSynced : !$checkSynced) {
                                return $q;
                            }
                        } else {
                            return $q;
                        }
                    });
                    $products[config('market_place.type_market')[2]]['product'] = $listProducts->filter();
                    $name[config('market_place.type_market')[2]]['market'] = $connectedMarketInfo->ecommerce_market_place_config->shorted_name;
                    $name[config('market_place.type_market')[2]]['id'] = $connectedMarketInfo->id;
                    $name[config('market_place.type_market')[2]]['synced'] = $ecommerceLinkProducts;
                }
            } elseif ($connectedMarketInfo->market_type == config('market_place.market_key.lazada')) {
                $listProducts = $this->repLazada->getProductList($token);
                $listProducts = $listProducts->map(function ($q) use ($ecommerceLinkProducts, $inputData) {
                    $checkSynced = count($ecommerceLinkProducts->where('parent_product_market_place_id', $q->item_id));
                    if (!empty($inputData['type'])) {
                        if ($inputData['type'] == 1 ? $checkSynced : !$checkSynced) {
                            return $q;
                        }
                    } else {
                        return $q;
                    }
                });

                $products[config('market_place.type_market')[3]]['product'] = $listProducts->filter();
                $name[config('market_place.type_market')[3]]['market'] = $connectedMarketInfo->ecommerce_market_place_config->shorted_name;
                $name[config('market_place.type_market')[3]]['id'] = $connectedMarketInfo->id;
                $name[config('market_place.type_market')[3]]['synced'] = $ecommerceLinkProducts;
            } elseif ($connectedMarketInfo->market_type == config('market_place.market_key.tiki')) {
                $products[config('market_place.type_market')[1]] = [];
            } elseif ($connectedMarketInfo->market_type == config('market_place.market_key.shopee')) {
                $products[config('market_place.type_market')[0]] = [];
            }
        }

        if (!count($products))
            return response_json(false, 'Chưa có sản phẩm trong kho');

        return response()->json([
            'status' => true,
            'view' => view('backend.market-place.product.list_data_product', compact('products', 'name'))->render()
        ]);
    }

    public function getListVariant(Request $request)
    {
        $inputData = $request->all();
        $marketId = $inputData['marketId'];
        $itemId = $inputData['sku'];
        $productInfo = '';

        $connectedMarket = $this->repEcommerceMarketPlace->getMarketById($marketId);
        if ($connectedMarket->market_type == config('market_place.market_key.sendo')) {
            $url = config('market_place.sendo.product_info_by_id') . $itemId;
            $productInMarket = MarketPlaceTrait::curlAPI($url, $connectedMarket->token, [], 'GET');
            $productInMarket = json_decode($productInMarket);
            if (empty($productInMarket) || $productInMarket->status_code !== 200) {
                return response_json(false, 'Sản phẩm không tồn tại');
            }

            $productInfo = $productInMarket->result;
            $productInfo->item_id = $productInfo->id;
        } else if ($connectedMarket->market_type == config('market_place.market_key.lazada')) {
            $appkey = config('market_place.lazada.client_id');
            $app_secret = config('market_place.lazada.secret_key');
            $client = new LazopClient(UrlConstants::$api_gateway_url_vn, $appkey, $app_secret);
            $request = new LazopRequest(config('market_place.lazada.product_info_by_sku'), 'GET');
            $request->addApiParam('item_id', $itemId);
            $productInMarket = $client->execute($request, $connectedMarket->token);
            $productInMarket = json_decode($productInMarket);
            if (!empty($productInMarket->code)) {
                return response_json(false, 'Sản phẩm không tồn tại');
            }
            $productInfo = new \stdClass();
            $variants = [];
            foreach ($productInMarket->data->skus as $skuInfo) {
                $variantInfo = new \stdClass();
                $variantInfo->variant_attribute_hash = $skuInfo->SkuId;
                $variantInfo->variant_sku = $skuInfo->SellerSku;
                $variants[] = $variantInfo;
            }

            $productInfo->variants = $variants;
            $productInfo->image = $productInMarket->data->images[0];
            $productInfo->name = $productInMarket->data->attributes->name;
            $productInfo->item_id = $productInMarket->data->item_id;

        }

        return view('backend.market-place.product.variants', compact('productInfo', 'marketId', 'connectedMarket'));
    }

    public function linkEachProduct(LinkProductRequest $request)
    {
        $inputData = $request->all();
        $productStockInfo = $this->repProductStock->getProductStockBySku($inputData['variant_sku']);
        if (empty($productStockInfo)) {
            return response_json(false, 'Sản phẩm không tồn tại trong kho');
        }

        $connectedMarket = $this->repEcommerceMarketPlace->getMarketById($inputData['market_id']);
        if ($connectedMarket->market_type == $this->sendoType) {
            return $this->repSendo->getEachDataToSync($inputData, $connectedMarket->token, $productStockInfo);
        }
        if ($connectedMarket->market_type == $this->lazadaType) {
            return $this->repLazada->linkVariantProduct($inputData, $connectedMarket, $productStockInfo);
        }
    }

    public function detailProductSynced(Request $request)
    {
        $inputData = $request->all();
        $checkSynced = $this->repEcommerceLinkProduct->getVariantProductById($inputData);
        if (empty($checkSynced))
            return response_json(false, 'Sản phẩm không tồn tại');

        $connectedMarket = $this->repEcommerceMarketPlace->getMarketById($inputData['market_id']);
        if ($connectedMarket->market_type == $this->sendoType) {
            $productInMarket = $this->repSendo->getProductById($inputData['product_sku'], $connectedMarket->token);
            if (empty($productInMarket)) {
                return response_json(false, 'Sản phẩm không tồn tại');
            }

            $variants = collect($productInMarket->result->variants);
            $variantProductDetail = $variants->where('variant_sku', $inputData['variant_sku'])->first();
            $moreData = [
                'name' => $productInMarket->result->name,
                'status' => $productInMarket->result->status,
                'id' => $productInMarket->result->id,
            ];
        }
        if ($connectedMarket->market_type == $this->lazadaType) {
            $productInMarket = $this->repLazada->getParentProductById($inputData['product_sku'], $connectedMarket->token);
            $variants = collect($productInMarket->data->skus);
            $variantProductDetail = $variants->where('SkuId', $inputData['variant_id'])->first();
            $variantProductDetail->variant_sku = $variantProductDetail->SellerSku;
            $variantProductDetail->variant_price = $variantProductDetail->price;
            $variantProductDetail->variant_quantity = $variantProductDetail->Available;
            $variantProductDetail->variant_attribute_hash = $variantProductDetail->SkuId;
            $moreData = [
                'name' => $productInMarket->data->attributes->name,
                'status' => $variantProductDetail->Status,
                'id' => $productInMarket->data->item_id,
            ];
        }

        $productStockInfo = $this->repProductStock->getProductStockBySku($inputData['variant_sku']);
        if (!empty($variantProductDetail)) {
            return response()->json([
                'status' => true,
                'view' => view('backend.market-place.product.market.detail_variant', compact('variantProductDetail', 'productStockInfo', 'moreData', 'connectedMarket'))->render(),
            ]);
        }

        return response_json(false, 'Sản phẩm không tồn tại');
    }

    public function disconnectProduct(Request $request)
    {
        $inputData = $request->all();
        $marketPlaceInfo = $this->repEcommerceMarketPlace->getMarketById($inputData['market_id']);
        if (empty($marketPlaceInfo)) {
            return response_json(false, 'Sản thương mại chưa được kết nối');
        }
        $variantId = $inputData['variant_id'];
        if (is_array($variantId)) {
            $variantIds = [];
            foreach ($variantId as $variantHashInfo) {
                if (count(explode('_var_', $variantHashInfo)) == 2)
                    $variantIds[] = 'var_' . explode('_var_', $variantHashInfo)[1];
            }
            $variantId = $variantIds;
        }

        $productLinkedIds = $this->repEcommerceLinkProduct->getLinkProductByVariantId($variantId, $inputData['market_id']);
        if (empty($productLinkedIds)) {
            return response_json(false, 'Sản phẩm chưa được liên kết');
        }

        foreach ($productLinkedIds as $productLinkedIdInfo)
            $productLinkedIdInfo->update(['is_deleted' => 1]);

        return response_json(true, 'Hủy liên kết sản phẩm thành công');
    }

    public function linkMultiProductByMarket(Request $request)
    {
        $inputData = $request->all();
        $marketPlaceId = $inputData['market_place_id'];
        $keyCache = 'market_place_' . $marketPlaceId;
        $marketPlaceInfo = Cache::remember($keyCache, 300, function () use ($marketPlaceId) {
            return $this->repEcommerceMarketPlace->getMarketById($marketPlaceId);
        });

        if ($inputData['all'] == 'false') {
            $variantHashs = $inputData['varianthash'];
            if (count($variantHashs)) {
                $parentArray = [];
                foreach ($variantHashs as $variantHashInfo) {
                    if (strpos($variantHashInfo, 'parent_') !== false) {
                        $parentArray[] = $variantHashInfo;
                    }
                }

                $variantHashs = array_diff($variantHashs, $parentArray);

                $this->syncDataByMarket($marketPlaceInfo, $variantHashs);
            }

            return response_json('true', 'Syncing');
        } else {
            $this->syncDataByMarket($marketPlaceInfo, []);

            return response_json('true', 'Syncing');
        }

        return response_json(true, 'Sản phẩm chưa có tại cửa hàng');
    }

    private function syncDataByMarket($marketPlaceInfo, $variantHashs)
    {
        if ($marketPlaceInfo->market_type == config('market_place.market_key.sendo')) {
            LinkProductInSendoToSystem::dispatch($variantHashs, $marketPlaceInfo);
        } elseif ($marketPlaceInfo->market_type == config('market_place.market_key.lazada')) {
            LinkProductInLazadaToSystem::dispatch($variantHashs, $marketPlaceInfo);
        } elseif ($marketPlaceInfo->market_type == config('market_place.market_key.tiki')) {
            LinkAllProductTikiById::dispatch($variantHashs, $marketPlaceInfo);
        }
    }

    public function syncAllProduct()
    {
        SyncAllProductInMarket::dispatch();

        return response_json(true, 'Sản phẩm đang được đồng bộ');

    }
}
