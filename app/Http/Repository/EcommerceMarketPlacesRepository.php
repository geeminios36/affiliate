<?php

namespace App\Http\Repository;

use App\BusinessSetting;
use App\EcommerceLinkProducts;
use App\EcommerceMarketPlace;
use App\Http\Traits\MarketPlaceTrait;
use App\LazadaLib\lazop\LazopClient;
use App\LazadaLib\lazop\LazopRequest;
use App\LazadaLib\lazop\UrlConstants;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EcommerceMarketPlacesRepository
{
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $sendoType;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $lazadaType;

    public function __construct()
    {
        $this->model = new EcommerceMarketPlace();
        $this->sendoType = config('market_place.market_key.sendo');
        $this->lazadaType = config('market_place.market_key.lazada');
    }

    public function getSendoOrderList($connectedMarketInfo, $token, $type_market)
    {
        $url = config('market_place.' . strtolower($type_market) . '.order_list');

        $array = [
            "page_size" => 50,
            "order_status" => "",
            "order_date_from" => date('Y-m-d', strtotime($connectedMarketInfo->created_at)),
            "order_date_to" => Carbon::now()->format('Y-m-d'),
            "order_status_date_from" => null,
            "order_status_date_to" => null,
            "token" => ""
        ];

        $firstListOrder = MarketPlaceTrait::curlAPI($url, $token, json_encode($array));
        $listOrder = json_decode($firstListOrder);

        if (isset($listOrder->success) && $listOrder->success) {
            if (!empty($listOrder->result->next_token)) {
                $listPage = (int)$listOrder->result->total_records / count($listOrder->result->data);
                $listPage = (int)floor($listPage);
                $dataNext = [];
                $i = 2;
                while ($i <= $listPage) {
                    if (!isset($listOrder->result))
                        break;

                    $array['token'] = $listOrder->result->next_token;

                    $listOrder = MarketPlaceTrait::curlAPI($url, $token, json_encode($array));
                    $dataNext[] = json_decode($listOrder)->result->data;
                }

                $firstListOrder = json_decode($firstListOrder)->result->data;
                $otherData = collect($dataNext)->flatten(1)->all();

                return array_merge($firstListOrder, $otherData);
            }

            return json_decode($firstListOrder)->result->data;
        }

        return [
            'status' => false,
            'msg' => $listOrder->exp
        ];
    }

    public function getSendoProductList($token, $type_market, $variant = false)
    {
        $url = config('market_place.' . strtolower($type_market) . '.product_list');
        $array = [
            "page_size" => 50,
            "product_name" => "",
            "date_from" => '',
            "date_to" => Carbon::now()->format('Y-m-d'),
            "status" => null,
            "token" => ""
        ];

        $firstListProduct = MarketPlaceTrait::curlAPI($url, $token, json_encode($array));
        $listProduct = json_decode($firstListProduct);

        if (isset($listProduct->success) && $listProduct->success) {
            if (!empty($listProduct->result->next_token)) {
                $listPage = (int)$listProduct->result->total_records / count($listProduct->result->data);
                $listPage = (int)floor($listPage);
                $dataNext = [];

                $i = 2;
                while ($i <= $listPage) {
                    if (!isset($listProduct->result))
                        break;

                    $array['token'] = $listProduct->result->next_token;

                    $listProduct = MarketPlaceTrait::curlAPI($url, $token, json_encode($array));
                    $dataNext[] = json_decode($listProduct)->result->data;
                }

                $firstListProduct = json_decode($firstListProduct)->result->data;
                $otherData = collect($dataNext)->flatten(1)->all();

                return array_merge($firstListProduct, $otherData);
            }

            if ($variant) {
                return collect(json_decode($firstListProduct)->result->data)->where('variants_length', '>', 0);
            }

            return collect(json_decode($firstListProduct)->result->data)->where('variants_length', '==', 0);
        }

        if (empty($listProduct))
            return response_json(false, 'Có lỗi xảy ra');
        return [
            'status' => false,
            'msg' => $listProduct->exp
        ];
    }

    public function getConnectionSendo()
    {
        return $this->model->with('ecommerce_market_place_config')
            ->where('status', 1)
            ->select('id', 'connection_info', 'token')
            ->where('market_type', config('market_place.market_key.sendo'))
            ->get();
    }

    public function getAllConnectedMarket()
    {
        return $this->model->where('status', 1)
            ->where('is_deleted', 0)
            ->with(['ecommerce_market_place_config'])
            ->get();
    }

    public function getMarketWithProducts()
    {
        return $this->model->where('status', 1)
            ->where('is_deleted', 0)
            ->withAndWhereHas('ecommerce_link_products', function ($query) {
                $query->with(['product_stock.product']);
            })->get();
    }

    public function getAllConnectedMarketToken()
    {
        return $this->model->where('status', 1)
            ->where('is_deleted', 0)
            ->pluck('token')->toArray();
    }

    public function getAllConnectedMarketByIds($ids)
    {
        $connectedMarket = $this->model->where('status', 1)
            ->where('is_deleted', 0);
        if (count($ids) > 0) {
            $connectedMarket = $connectedMarket->whereIn('id', $ids);
        }

        $connectedMarket = $connectedMarket->with('ecommerce_market_place_config')
            ->get();

        return $connectedMarket;
    }

    public function getAllMarket()
    {
        return EcommerceMarketPlace::where('is_deleted', 0)
            ->with(['ecommerce_link_products'])
            ->get();
    }

    public function getMarketById($ecommerceMarketPlaceId)
    {
        return $this->model->whereId($ecommerceMarketPlaceId)->first();
    }

    public function syncSendo($productMarketIdsSynced, $token)
    {
        $urlUpdateProduct = config('market_place.sendo.update_or_create_multi_products');
        $listDataUpdate = [];
        $skus = [];
        foreach ($productMarketIdsSynced as $linkedProductInfo) {
            if (empty($productStockInfo->product))
                continue;

            $productInMarket = json_decode($linkedProductInfo->product_detail)->result;
            $productStockInfo = $linkedProductInfo->product_stock;
            $photos = collect();

            collect(explode(',', $productStockInfo->product->photos))->map(function ($idImage) use ($photos) {
                return $photos->push([
                    'picture_url' => uploaded_asset($idImage)
                ]);
            });
            $pictures = $productInMarket->pictures;
            $photos = count($pictures) == 10 ? $pictures : collect($productInMarket->pictures)
                ->merge($photos)->take(10)
                ->toArray();

            $avatar = uploaded_asset($productStockInfo->product->thumbnail_img) !== null ? uploaded_asset($productStockInfo->product->thumbnail_img) : $productInMarket->avatar->picture_url;
            $tag = (empty($productStockInfo->product->tags) ? $productInMarket->tags : str_replace('#', ' ', $productStockInfo->product->tags));
            $unit = (isset($this->unit[trim(preg_replace('/\d/', '', $productStockInfo->product->unit))]) ? $this->unit[trim(preg_replace('/\d/', '', $productStockInfo->product->unit))] : $productInMarket->unit_id);

            $listDataUpdate[] = [
                "id" => $linkedProductInfo->product_market_place_id,
                "stock_quantity" => $productStockInfo->qty,
                "cat_4_id" => $productInMarket->cat_4_id,
                "avatar" => [
                    "picture_url" => $avatar,
                ],
                "name" => $productStockInfo->product->name,
                "sku" => $productStockInfo->sku,
                "price" => (int)$productStockInfo->price,
                "description" => $productStockInfo->product->description,
                "extended_shipping_package" => $productInMarket->extended_shipping_package,
                "variants" => $productInMarket->variants,
                "voucher" => $productInMarket->voucher,
                "tag" => $tag,
                "relateds" => $productInMarket->relateds,
                "seo_keyword" => $productStockInfo->product->meta_title,
                "seo_title" => $productStockInfo->product->meta_title,
                "seo_description" => $productStockInfo->product->meta_description,
                "unit_id" => $unit,
                "pictures" => $photos,
                "height" => $productInMarket->height,
                "length" => $productInMarket->length,
                "width" => $productInMarket->width,
            ];
            $skus[] = $productStockInfo->sku;
        }

        $linkProductTogether = MarketPlaceTrait::curlAPI($urlUpdateProduct, $token, json_encode(array_filter($listDataUpdate)));

        $linkProductTogether = json_decode($linkProductTogether);

        if ($linkProductTogether->status_code == 200) {
            foreach ($skus as $sku) {
                $url = config('market_place.sendo.product_info_by_sku') . $sku;
                $productInMarket = MarketPlaceTrait::curlAPI($url, $token, [], 'GET');
                $productInMarketInfo = json_decode($productInMarket)->result;
                EcommerceLinkProducts::where('product_market_place_id', $productInMarketInfo->id)->update([
                    'product_detail' => $productInMarket,
                ]);
            }
        }
    }

    public function syncLazada($productMarketIdsSynced, $token)
    {
        $appkey = config('market_place.lazada.client_id');
        $app_secret = config('market_place.lazada.secret_key');
        foreach ($productMarketIdsSynced as $linkedProductInfo) {
            if (empty($linkedProductInfo->product_stock))
                continue;

            $client = new LazopClient(UrlConstants::$api_gateway_url_vn, $appkey, $app_secret);
            $request = new LazopRequest(config('market_place.lazada.product_info_by_sku'), 'GET');
            $request->addApiParam('seller_sku', $linkedProductInfo->product_stock->sku);
            $productInMarket = $client->execute($request, $token);
            $productInMarket = json_decode($productInMarket);
            if (!empty($productInMarket->code))
                continue;

            $productInMarket = $productInMarket->data;
            $payload = '<?xml version="1.0" encoding="UTF-8" ?>
                     <Request>
                       <Product>
                          <ItemId>' . $productInMarket->item_id . '</ItemId>
                          <Attributes>
                             <name>' . $linkedProductInfo->product_stock->product->name . '</name>
                             <short_description></short_description>
                          </Attributes>
                          <Skus>
                             <Sku>
                                <SkuId>' . $productInMarket->skus[0]->SkuId . '</SkuId>
                                <SellerSku>' . $productInMarket->skus[0]->SellerSku . '</SellerSku>
                                <quantity>' . $linkedProductInfo->product_stock->qty . '</quantity>
                                <price>' . $linkedProductInfo->product_stock->price . '</price>
                                <package_length>' . $productInMarket->skus[0]->package_length . '</package_length>
                                <package_height>' . $productInMarket->skus[0]->package_height . '</package_height>
                                <package_weight>' . $productInMarket->skus[0]->package_weight . '</package_weight>
                                <package_width>' . $productInMarket->skus[0]->package_width . '</package_width>
                                 <package_content></package_content>
                                <Images></Images>
                             </Sku>
                          </Skus>
                       </Product>
                    </Request>';

            $request = new LazopRequest(config('market_place.lazada.product_update'));
            $request->addApiParam('payload', $payload);
            $client->execute($request, $token);

            $productDetail = new \stdClass();
            $result = new  \stdClass();
            $avatar = new  \stdClass();
            $avatar->picture_url = uploaded_asset($linkedProductInfo->product_stock->product->thumbnail_img);
            $result->id = $productInMarket->item_id;
            $result->name = $linkedProductInfo->product_stock->product->name;
            $result->sku = $linkedProductInfo->product_stock->sku;
            $result->price = $linkedProductInfo->product_stock->price;
            $result->avatar = $avatar;
            $result->stock_quantity = $linkedProductInfo->product_stock->qty;
            $productDetail->result = $result;

            EcommerceLinkProducts::where('product_market_place_id', $productInMarket->item_id)->update([
                'product_detail' => json_encode($productDetail),
            ]);
        }
    }

}
