<?php

namespace App\Http\Repository;

use App\EcommerceLinkProducts;
use App\Http\Traits\MarketPlaceTrait;
use App\LazadaLib\lazop\LazopClient;
use App\LazadaLib\lazop\LazopRequest;
use App\LazadaLib\lazop\UrlConstants;
use App\ProductStock;
use Illuminate\Support\Facades\Auth;

class lazadaRepsitory
{

    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $appSecret;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $appKey;
    /**
     * @var EcommerceLinkProductRepository
     */
    private $repLinkProduct;

    public function __construct()
    {
        $this->appKey = config('market_place.lazada.client_id');
        $this->appSecret = config('market_place.lazada.secret_key');
        $this->repLinkProduct = new EcommerceLinkProductRepository();
    }

    public function linkProduct($marketPlaceInfo, $productStockInfo)
    {
        $sku = $productStockInfo->sku;
        $client = new LazopClient(UrlConstants::$api_gateway_url_vn, $this->appKey, $this->appSecret);

        $request = new LazopRequest(config('market_place.lazada.product_info_by_sku'), 'GET');
        $request->addApiParam('seller_sku', $sku);
        $productInMarket = $client->execute($request, $marketPlaceInfo->token);
        $productInMarket = json_decode($productInMarket);
        if (isset($productInMarket->type) && $productInMarket->type == 'ISV') {
            return response_json(false, 'Vui lòng đăng nhập lại cửa hàng Lazada');
        }
        if (!empty($productInMarket->code))
            return response_json(false, 'Không tồn tại sản phẩm có mã SKU này');

        $productInMarket = $productInMarket->data;

        $description = trim(preg_replace('/\s\s+/', '', $productStockInfo->product->description));
        $payload = '<?xml version="1.0" encoding="UTF-8" ?>
                     <Request>
                       <Product>
                          <ItemId>' . $productInMarket->item_id . '</ItemId>
                          <Attributes>
                             <name>' . $productStockInfo->product->name . '</name>
                             <short_description>' . $description . '</short_description>
                          </Attributes>
                          <Skus>
                             <Sku>
                                <SkuId>' . $productInMarket->skus[0]->SkuId . '</SkuId>
                                <SellerSku>' . $productInMarket->skus[0]->SellerSku . '</SellerSku>
                                <quantity>' . $productStockInfo->qty . '</quantity>
                                <price>' . $productStockInfo->price . '</price>
                                <package_length>' . $productInMarket->skus[0]->package_length . '</package_length>
                                <package_height>' . $productInMarket->skus[0]->package_height . '</package_height>
                                <package_weight>' . $productInMarket->skus[0]->package_weight . '</package_weight>
                                <package_width>' . $productInMarket->skus[0]->package_width . '</package_width>
                                 <package_content>' . $productStockInfo->product->name . '</package_content>
                                <Images></Images>
                             </Sku>
                          </Skus>
                       </Product>
                    </Request>';

        $request = new LazopRequest(config('market_place.lazada.product_update'));
        $request->addApiParam('payload', $payload);
        $responseUpdateName = $client->execute($request, $marketPlaceInfo->token);
        $responseUpdateName = json_decode($responseUpdateName);
        if ($responseUpdateName->code == 0) {
            $data = [
                'item_id' => $productInMarket->item_id,
                'avatar' => uploaded_asset($productStockInfo->product->thumbnail_img),
                'name' => $productInMarket->attributes->name,
                'sku_id' => $productInMarket->skus[0]->SkuId,
                'seller_sku' => $sku,
                'price' => $productStockInfo->price,
                'qty' => $productStockInfo->qty,
                'ecommerce_market_place_id' => $marketPlaceInfo->id,
                'product_stock_id' => $productStockInfo->id,
            ];

            $this->repLinkProduct->createLinkProductTogether($data);

            return response_json(true, 'Liên kết sản phẩm thành công');

        }

        return response_json(false, $responseUpdateName->detail[0]->message);

    }

    public function linkVariantProduct($inputData, $marketPlaceInfo, $productStockInfo)
    {
        $sku = $productStockInfo->sku;
        $client = new LazopClient(UrlConstants::$api_gateway_url_vn, $this->appKey, $this->appSecret);

        $request = new LazopRequest(config('market_place.lazada.product_info_by_sku'), 'GET');
        $request->addApiParam('seller_sku', $sku);
        $productInMarket = $client->execute($request, $marketPlaceInfo->token);
        $productInMarket = json_decode($productInMarket);
        if (isset($productInMarket->type) && $productInMarket->type == 'ISV') {
            return response_json(false, 'Vui lòng đăng nhập lại cửa hàng Lazada');
        }
        if (!empty($productInMarket->code))
            return response_json(false, 'Không tồn tại sản phẩm có mã SKU này');

        $productInMarket = $productInMarket->data;
        $description = trim(preg_replace('/\s\s+/', '', $productStockInfo->product->description));
        $payload = '<?xml version="1.0" encoding="UTF-8" ?>
                     <Request>
                       <Product>
                          <ItemId>' . $productInMarket->item_id . '</ItemId>
                          <Attributes>
                             <name>' . $productStockInfo->product->name . '</name>
                             <short_description>' . $description . '</short_description>
                          </Attributes>
                          <Skus>
                             <Sku>
                                <SkuId>' . $productInMarket->skus[0]->SkuId . '</SkuId>
                                <SellerSku>' . $productInMarket->skus[0]->SellerSku . '</SellerSku>
                                <quantity>' . $productStockInfo->qty . '</quantity>
                                <price>' . $productStockInfo->price . '</price>
                                <package_length>' . $productInMarket->skus[0]->package_length . '</package_length>
                                <package_height>' . $productInMarket->skus[0]->package_height . '</package_height>
                                <package_weight>' . $productInMarket->skus[0]->package_weight . '</package_weight>
                                <package_width>' . $productInMarket->skus[0]->package_width . '</package_width>
                                 <package_content>' . $productStockInfo->product->name . '</package_content>
                                <Images></Images>
                             </Sku>
                          </Skus>
                       </Product>
                    </Request>';

        $request = new LazopRequest(config('market_place.lazada.product_update'));
        $request->addApiParam('payload', $payload);
        $responseUpdateName = $client->execute($request, $marketPlaceInfo->token);
        $responseUpdateName = json_decode($responseUpdateName);
        if ($responseUpdateName->code == 0) {
            $data = [
                'item_id' => $productInMarket->item_id,
                'avatar' => uploaded_asset($productStockInfo->product->thumbnail_img),
                'name' => $productInMarket->attributes->name,
                'sku_id' => $productInMarket->skus[0]->SkuId,
                'seller_sku' => $sku,
                'price' => $productStockInfo->price,
                'qty' => $productStockInfo->qty,
                'ecommerce_market_place_id' => $marketPlaceInfo->id,
                'product_stock_id' => $productStockInfo->id,
            ];

            $this->repLinkProduct->createLinkProductTogether($data);

            return response_json(true, 'Liên kết sản phẩm thành công');

        }

        return response_json(false, $responseUpdateName->detail[0]->message);

    }

    public function getProductList($token)
    {
        $client = new LazopClient(UrlConstants::$api_gateway_url_vn, $this->appKey, $this->appSecret);
        $request = new LazopRequest('/products/get', 'GET');
        $productList = $client->execute($request, $token);
        $productList = json_decode($productList);
        if (empty($productList->code)) {
            return collect($productList->data->products);
        }

        return [];
    }

    /**
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function getParentProductById($item_id, $token)
    {
        $client = new LazopClient(UrlConstants::$api_gateway_url_vn, $this->appKey, $this->appSecret);
        $request = new LazopRequest(config('market_place.lazada.product_info_by_sku'), 'GET');
        $request->addApiParam('item_id', $item_id);
        $productInMarket = $client->execute($request, $token);
        $productInMarket = json_decode($productInMarket);
        if (!empty($productList->code)) {
            return response_json(false, 'Sản phẩm không tồn tại');
        }

        return $productInMarket;
    }

    public function linkDataInMarketToSystem($variants, $productStockData, $productInMarket, $productId, $marketPlaceInfo)
    {
        $client = new LazopClient(UrlConstants::$api_gateway_url_vn, $this->appKey, $this->appSecret);
        $childItem = '';
        $skuIdArray = [];
        foreach ($variants as $variantInfo) {
            $productStockInfo = $productStockData->where('sku', $variantInfo->SellerSku)->first();
            if (empty($productStockInfo) || empty($productStockInfo->product))
                continue;

            if ($variantInfo->quantity > $productStockInfo->qty) {
                $quantity = empty($productStockInfo->qty) ? 0 : $productStockInfo->qty;
            } else {
                $quantity = empty($variantInfo->quantity) ? 0 : $variantInfo->quantity;
                ProductStock::where('id', $productStockInfo->id)->update(['qty' => empty($variantInfo->quantity) ? 0 : $variantInfo->quantity]);
            }

            $childItem .= '
                               <Sku>
                                <SkuId>' . $variantInfo->SkuId . '</SkuId>
                                <SellerSku>' . $variantInfo->SellerSku . '</SellerSku>
                                <quantity>' . $quantity . '</quantity>
                                <price>' . $productStockInfo->price . '</price>
                                <package_length>' . $variantInfo->package_length . '</package_length>
                                <package_height>' . $variantInfo->package_height . '</package_height>
                                <package_weight>' . $variantInfo->package_weight . '</package_weight>
                                <package_width>' . $variantInfo->package_width . '</package_width>
                                 <package_content>' . $variantInfo->package_content . '</package_content>
                                <Images></Images>
                             </Sku>';

            $skuIdArray[$variantInfo->SkuId] = [
                'sku' => $variantInfo->SellerSku,
                'price' => $productStockInfo->price,
                'qty' => $quantity,
                'id' => $productStockInfo->id
            ];
        }

        $payload = '<?xml version="1.0" encoding="UTF-8" ?>
                     <Request>
                       <Product>
                          <ItemId>' . $productInMarket->item_id . '</ItemId>
                          <Attributes>
                             <name>' . $productInMarket->attributes->name . '</name>
                             <short_description>' . $productInMarket->attributes->description . '</short_description>
                          </Attributes>
                          <Skus>
                             ' . $childItem . '
                          </Skus>
                       </Product>
                    </Request>';

        $request = new LazopRequest(config('market_place.lazada.product_update'));
        $request->addApiParam('payload', $payload);
        $responseUpdateName = $client->execute($request, $marketPlaceInfo->token);
        if (json_decode($responseUpdateName)->code == 0) {
            foreach ($skuIdArray as $skuId => $sku) {
                $data = [
                    'item_id' => $productInMarket->item_id,
                    'avatar' => isset($productInMarket->images[0]) ? $productInMarket->images[0] : '',
                    'name' => $productInMarket->attributes->name,
                    'sku_id' => $skuId,
                    'seller_sku' =>  $sku['sku'],
                    'price' => $sku['price'],
                    'qty' => $sku['qty'],
                    'ecommerce_market_place_id' => $marketPlaceInfo->id,
                    'product_stock_id' => $sku['id'],
                ];

                $this->repLinkProduct->createLinkProductTogether($data);
            }
        }
    }

    public function syncProductInMarketToSystem($productMarketIdsSynced, $marketPlaceInfo)
    {
        $addParent = collect();
        $productMarketIdsSynced = $productMarketIdsSynced->where('ecommerce_market_place_id', $marketPlaceInfo->id);
        foreach ($productMarketIdsSynced as $productMarketIdsSyncedInfo) {
            $addParent->push([
                'parent_id' => $productMarketIdsSyncedInfo->parent_product_market_place_id,
                'variant_id' => str_replace('var_', '', $productMarketIdsSyncedInfo->product_market_place_id),
            ]);
        }

        $addParent = $addParent->groupBy('parent_id');
        $client = new LazopClient(UrlConstants::$api_gateway_url_vn, $this->appKey, $this->appSecret);
        foreach ($addParent as $productId => $childIds) {
            $childIdArray = $childIds->pluck('variant_id')->toArray();

            $request = new LazopRequest(config('market_place.lazada.product_info_by_sku'), 'GET');
            $request->addApiParam('item_id', $productId);
            $productInMarket = $client->execute($request, $marketPlaceInfo->token);
            $productInMarket = json_decode($productInMarket);
            if (!isset($productInMarket->data))
                continue;

            $variants = collect($productInMarket->data->skus)->whereIn('SkuId', $childIdArray);

            $productStockData = $productMarketIdsSynced->pluck('product_stock');

            $this->linkDataInMarketToSystem($variants, $productStockData, $productInMarket->data, $productId, $marketPlaceInfo);
        }
    }
}
