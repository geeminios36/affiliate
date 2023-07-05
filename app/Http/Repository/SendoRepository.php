<?php

namespace App\Http\Repository;

use App\EcommerceLinkProducts;
use App\Http\Traits\MarketPlaceTrait;
use App\ProductStock;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Exception;

class SendoRepository
{
    /**
     * @var EcommerceLinkProductRepository
     */
    private $repEcommerceLinkProduct;

    public function __construct()
    {
        $this->repEcommerceLinkProduct = new EcommerceLinkProductRepository();
    }

    public function getEachDataToSync($inputData, $token, $productStockInfo)
    {
        $url = config('market_place.sendo.product_info_by_id') . $inputData['product_sku'];
        $productInMarket = MarketPlaceTrait::curlAPI($url, $token, [], 'GET');
        $productInMarket = json_decode($productInMarket);
        if ($productInMarket->status_code !== 200) {
            return response_json(false, 'Sản phẩm không tồn tại');
        }
        $variants = collect($productInMarket->result->variants);
        $updatedVariant = $variants
            ->where('variant_sku', $inputData['variant_sku'])
            ->first();
        $variantQuantityTotal = $variants->sum('variant_quantity') - $updatedVariant->variant_quantity + $productStockInfo->qty;
        foreach ($variants as $variantInfo) {
            $variantInfo->variant_quantity = empty($variantInfo->variant_quantity) ? 0 : $variantInfo->variant_quantity;
            if ($variantInfo->variant_sku == $inputData['variant_sku']) {
                $variantInfo->variant_price = $productStockInfo->price;
                if ($variantInfo->variant_quantity > $productStockInfo->qty) {
                    $variantInfo->variant_quantity = empty($productStockInfo->qty) ? 0 : $productStockInfo->qty;
                } else {
                    ProductStock::where('id', $productStockInfo->id)->update(['qty' => empty($variantInfo->variant_quantity) ? 0 : $variantInfo->variant_quantity]);
                }
            }
        }
        $data = [
            'token' => $token,
            'ecommerce_market_place_d' => $inputData['market_id'],
            'product_in_market' => $productInMarket,
            'product_current' => $productStockInfo,
            'total_quantity' => $variantQuantityTotal,
            'updated_variant' => json_encode($variants->toArray()),
            'current_variant' => $updatedVariant
        ];

        return $this->linkEachVariantProductToMarket($data);
    }

    public function linkEachVariantProductToMarket($arrayData)
    {
        $urlUpdateProduct = config('market_place.sendo.update_or_create_product');
        $productInMarket = $arrayData['product_in_market'];
        $productStockInfo = $arrayData['product_current'];
        $object =
            '{
                 "id":' . $productInMarket->result->id . ',
                 "name":"' . $productInMarket->result->name . '",
                 "sku":"' . $productInMarket->result->sku . '",
                 "price":' . $productInMarket->result->price . ',
                 "stock_availability": true,
                 "stock_quantity":' . $arrayData['total_quantity'] . ',
                 "description":"' . $productInMarket->result->description . '",
                 "cat_4_id":"' . $productInMarket->result->cat_4_id . '",
                 "tags":"' . $productInMarket->result->tags . '",
                 "seo_keyword":"' . $productInMarket->result->seo_keyword . '",
                 "seo_title":"' . $productInMarket->result->seo_title . '",
                 "seo_description":"' . $productInMarket->result->seo_description . '",
                 "height": ' . $productInMarket->result->height . ',
                 "length": ' . $productInMarket->result->length . ',
                 "width": ' . $productInMarket->result->width . ',
                 "weight": ' . (empty($productInMarket->result->weight) ? 10 : $productInMarket->result->weight) . ',
                 "unit_id":"' . $productInMarket->result->unit_id . '",
                 "avatar": {
                      "picture_url": "' . $productInMarket->result->avatar->picture_url . '",
                 },
                 "pictures": ' . json_encode($productInMarket->result->pictures) . ',
                 "attributes": ' . json_encode($productInMarket->result->attributes) . ',
                 "extended_shipping_package":' . json_encode($productInMarket->result->extended_shipping_package) . ',
                 "variants":' . $arrayData['updated_variant'] . ',
                 "is_config_variant": true,
                 "voucher":' . json_encode($productInMarket->result->voucher) . '
            }';
        try {
            $linkProductTogether = MarketPlaceTrait::curlAPI($urlUpdateProduct, $arrayData['token'], $object);
            $linkProductTogether = json_decode($linkProductTogether);

            if ($linkProductTogether->status_code == 200) {
                $data = [
                    'item_id' => $productInMarket->result->id,
                    'avatar' => $productInMarket->result->image,
                    'name' => $productInMarket->result->name,
                    'sku_id' => $arrayData['current_variant']->variant_attribute_hash,
                    'seller_sku' => $arrayData['current_variant']->variant_sku,
                    'price' => $arrayData['current_variant']->variant_price,
                    'qty' => $arrayData['current_variant']->variant_quantity,
                    'ecommerce_market_place_id' => $arrayData['ecommerce_market_place_d'],
                    'product_stock_id' => $productStockInfo->id,
                ];

                $this->repEcommerceLinkProduct->createLinkProductTogether($data);

            }
        } catch (Exception $exception) {
            dd($exception);
        }

        if ($linkProductTogether->status_code !== 200) {
            return response_json(false, 'Có lỗi xảy ra trong quá trình đồng bộ', $linkProductTogether);
        }

        return response_json(true, 'Đồng bộ sản phẩm thành công');
    }

    public function getProductById($itemId, $token)
    {
        $url = config('market_place.sendo.product_info_by_id') . $itemId;
        $productInMarket = MarketPlaceTrait::curlAPI($url, $token, [], 'GET');
        $productInMarket = json_decode($productInMarket);
        if ($productInMarket->status_code !== 200) {
            return '';
        }

        return $productInMarket;
    }

    public function linkMultiProductInMarketToSystem($addParent, $marketPlaceInfo)
    {
        $data = [];
        $ItemIds = [];
        foreach ($addParent as $parenId => $variantChild) {
            $listVariantHash = $variantChild->pluck('variant_id')->filter()->unique()->toArray();

            $url = config('market_place.sendo.product_info_by_id') . $parenId;
            $productParentInfo = MarketPlaceTrait::curlAPI($url, $marketPlaceInfo->token, [], 'GET');
            $productParentInfo = json_decode($productParentInfo);
            if (empty($productParentInfo) || $productParentInfo->status_code !== 200) {
                continue;
            }

            $productParentInfo = $productParentInfo->result;
            $variants = collect($productParentInfo->variants);
            $variantSkuArray = $variants->pluck('variant_sku')->toArray();
            $productStockData = ProductStock::whereIn('sku', $variantSkuArray)->get();

            $productStockArray = [];
            foreach ($variants as $key => $variantInfo) {
                $variants[$key]->variant_quantity = empty($variantInfo->variant_quantity) ? 0 : $variantInfo->variant_quantity;

                $productStockInfo = (!empty($productStockData)) ? $productStockData->where('sku', $variantInfo->variant_sku)->first() : '';

                if (!empty($productStockInfo) && in_array($variantInfo->variant_attribute_hash, $listVariantHash)) {
                    $productStockInfo->variantInfo = $variantInfo;
                    $productStockInfo->avatar = $productParentInfo->avatar->picture_url;
                    $productStockArray[] = $productStockInfo;
                    $variants[$key]->variant_price = $productStockInfo->price;
                    if ($variantInfo->variant_quantity > $productStockInfo->qty) {
                        $variants[$key]->variant_quantity = empty($productStockInfo->qty) ? 0 : $productStockInfo->qty;
                    } else {
                        ProductStock::where('id', $productStockInfo->id)->update(['qty' => empty($variantInfo->variant_quantity) ? 0 : $variantInfo->variant_quantity]);
                    }
                }
            }

            $variants = $variants->merge(collect($productParentInfo->variants)
                ->whereNotIn('variant_sku', $variantSkuArray));

            $ItemIds[$parenId] = $productStockArray;

            $data[] = $this->getDataToUpdate($parenId, $productParentInfo, $variants->sum('variant_quantity'), $variants->toArray());
        }

        $urlUpdateProduct = config('market_place.sendo.update_or_create_multi_products');

        $linkProductTogether = MarketPlaceTrait::curlAPI($urlUpdateProduct, $marketPlaceInfo->token, json_encode($data));

        $linkProductTogether = json_decode($linkProductTogether);
        if ($linkProductTogether->status_code == 200 && !count($linkProductTogether->result->error_list)) {
            return $this->updateOrCreateLinkMarket($ItemIds, $marketPlaceInfo);
        }
    }

    public function syncProductInMarketToSystem($productMarketIdsSynced, $marketPlaceInfo)
    {
        $addParent = collect();
        foreach ($productMarketIdsSynced as $productMarketIdsSyncedInfo) {
            $addParent->push([
                'parent_id' => $productMarketIdsSyncedInfo->parent_product_market_place_id,
                'variant_id' => str_replace('var_', '', $productMarketIdsSyncedInfo->product_market_place_id),
            ]);
        }

        $addParent = $addParent->groupBy('parent_id');

        return $this->linkMultiProductInMarketToSystem($addParent, $marketPlaceInfo);
    }

    public function getDataToUpdate($productId, $productParentInfo, $totalVariantQuantity, $variants)
    {
        return [
            "id" => $productId,
            "name" => $productParentInfo->name,
            "store_sku" => $productParentInfo->sku,
            "price" => (int)$productParentInfo->price,
            "weight" => $productParentInfo->weight,
            "stock_availability" => $totalVariantQuantity > 0 ? true : false,
            "description" => $productParentInfo->description,
            "cat_4_id" => $productParentInfo->cat_4_id,
            "product_status" => $productParentInfo->status,
            "product_tags" => $productParentInfo->tags,
            "seo" => $productParentInfo->seo,
            "product_link" => $productParentInfo->link,
            "product_relateds" => $productParentInfo->relateds,
            "seo_key_word" => $productParentInfo->seo_keyword,
            "seo_title" => $productParentInfo->seo_title,
            "seo_description" => $productParentInfo->seo_description,
            "seo_score" => $productParentInfo->seo_score,
            "product_image" => $productParentInfo->image,
            "category_name" => $productParentInfo->category_4_name,
            "is_enable" => true,
            "reason_comment" => "",
            "reason_code" => "",
            "is_inventory_control" => true,
            "brand_id" => $productParentInfo->brand_id,
            "brand_name" => $productParentInfo->brand_name,
            "is_review" => true,
            "review_date_timestamp" => 0,
            "url_path" => $productParentInfo->url_path,
            "video_links" => $productParentInfo->video_links,
            "height" => $productParentInfo->height,
            "length" => $productParentInfo->length,
            "width" => $productParentInfo->width,
            "unit_id" => $productParentInfo->unit_id,
            "stock_quantity" => $totalVariantQuantity,
            "avatar" => [
                "picture_url" => $productParentInfo->avatar->picture_url,
            ],
            "pictures" => $productParentInfo->pictures,
            "attributes" => $productParentInfo->attributes,
            "version_no" => '',
            "promotion_from_date" => $productParentInfo->promotion_from_date_timestamp,
            "promotion_to_date" => $productParentInfo->promotion_to_date_timestamp,
            "is_review_type" => 0,
            "is_promotion" => $productParentInfo->is_promotion,
            "promotion_note" => '',
            "filter_type" => 0,
            "extended_shipping_package" => $productParentInfo->extended_shipping_package,
            "variants" => $variants,
            "is_config_variant" => true,
            "is_config_variant_cate" => true,
            "special_price" => $productParentInfo->special_price,
            "voucher" => $productParentInfo->voucher,

        ];
    }

    public function updateOrCreateLinkMarket($ItemIds, $marketPlaceInfo)
    {
        foreach ($ItemIds as $idProductConnecting => $productStockData) {
            foreach ($productStockData as $productStockInfo) {
                $data = [
                    'item_id' => $idProductConnecting,
                    'avatar' => '',
                    'name' => $productStockInfo->product->name,
                    'sku_id' => $productStockInfo->variantInfo->variant_attribute_hash,
                    'seller_sku' =>  $productStockInfo->variantInfo->variant_sku,
                    'price' => $productStockInfo->variantInfo->variant_price,
                    'qty' => $productStockInfo->variantInfo->variant_quantity,
                    'ecommerce_market_place_id' => $marketPlaceInfo->id,
                    'product_stock_id' => $productStockInfo->id,
                ];

                $this->repEcommerceLinkProduct->createLinkProductTogether($data);
            }
        }
    }

    public function linkOneProductToMarket($arrayData)
    {
        $idProductConnecting = $arrayData['id'];
        $token = $arrayData['token'];
        $urlUpdateProduct = $arrayData['url'];
        $marketPlaceId = $arrayData['ecommerce_market_place_d'];
        $productInMarket = $arrayData['product_in_market'];
        $productStockInfo = $arrayData['product_current'];
        $photos = collect();

        collect(explode(',', $productStockInfo->product->photos))->map(function ($idImage) use ($photos) {
            return $photos->push([
                'picture_url' => uploaded_asset($idImage)
            ]);
        });

        $pictures = $productInMarket->result->pictures;
        $photos = count($pictures) == 10 ? $pictures : collect($productInMarket->result->pictures)
            ->merge($photos)->take(10)
            ->toArray();

        $avatar = uploaded_asset($productStockInfo->product->thumbnail_img) !== null ? uploaded_asset($productStockInfo->product->thumbnail_img) : $productInMarket->result->avatar->picture_url;
        $tag = (empty($productStockInfo->product->tags) ? $productInMarket->result->tags : str_replace('#', ' ', $productStockInfo->product->tags));
        $unit = (isset($this->unit[trim(preg_replace('/\d/', '', $productStockInfo->product->unit))]) ?
            $this->unit[trim(preg_replace('/\d/', '', $productStockInfo->product->unit))] :
            $productInMarket->result->unit_id);
        $object =
            '{
                 "id":' . $idProductConnecting . ',
                 "stock_quantity":' . $productStockInfo->qty . ',
                 "avatar": {
                      "picture_url": "' . $avatar . '",
                 },
                 "name":"' . $productStockInfo->product->name . '",
                 "sku":"' . $productStockInfo->sku . '",
                 "price":' . (int)$productStockInfo->price . ',
                 "description":"' . $productStockInfo->product->description . '",
                 "cat_4_id":"' . $productInMarket->result->cat_4_id . '",
                 "extended_shipping_package":' . json_encode($productInMarket->result->extended_shipping_package) . ',
                 "variants":' . json_encode($productInMarket->result->variants) . ',
                 "voucher":' . json_encode($productInMarket->result->voucher) . ',
                 "tags":"' . $tag . '",
                  "relateds":' . json_encode($productInMarket->result->relateds) . ',
                 "seo_keyword":"' . $productStockInfo->product->meta_title . '",
                 "seo_title":"' . $productStockInfo->product->meta_title . '",
                 "seo_description":"' . $productStockInfo->product->meta_description . '",
                 "unit_id":"' . $unit . '",
                 "pictures": ' . json_encode($photos) . ',
                 "height": ' . $productInMarket->result->height . ',
                 "length": ' . $productInMarket->result->length . ',
                 "width": ' . $productInMarket->result->width . '
            }';

        try {
            $linkProductTogether = MarketPlaceTrait::curlAPI($urlUpdateProduct, $token, $object);
            $linkProductTogether = json_decode($linkProductTogether);
            if ($linkProductTogether->status_code == 200) {
//                $url = config('market_place.sendo.product_info_by_sku') . $productStockInfo->sku;
//                $productInMarket = MarketPlaceTrait::curlAPI($url, $token, [], 'GET');

                $data = [
                    'item_id' => 0,
                    'avatar' => $avatar,
                    'name' => $productStockInfo->product->name,
                    'sku_id' => $idProductConnecting,
                    'seller_sku' => $productStockInfo->sku,
                    'price' => $productStockInfo->price,
                    'qty' => $productStockInfo->qty,
                    'ecommerce_market_place_id' => $marketPlaceId,
                    'product_stock_id' => $productStockInfo->id,
                ];

                $this->repEcommerceLinkProduct->createLinkProductTogether($data);
            }
        } catch (Exception $exception) {
        }

    }

    public function syncMultiProductToMarket($marketPlaceInfo, $listData)
    {
        $urlUpdateProduct = config('market_place.sendo.update_or_create_multi_products');
        $marketPlaceId = $marketPlaceInfo->id;
        $data = [];
        foreach ($listData as $idProductConnecting => $productInfo) {
            $productInMarket = $productInfo['product_in_market']->result;
            $productStockInfo = $productInfo['product_current'];
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
            $data[] = [
                "id" => $idProductConnecting,
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
                "unit_id" => $productInMarket->unit_id,
                "pictures" => $photos,
                "height" => $productInMarket->height,
                "length" => $productInMarket->length,
                "width" => $productInMarket->width,
            ];
        }

        $linkProductTogether = MarketPlaceTrait::curlAPI($urlUpdateProduct, $marketPlaceInfo->token, json_encode($data));

        $linkProductTogether = json_decode($linkProductTogether);

        if ($linkProductTogether->status_code == 200) {
            foreach ($listData as $idProductConnecting => $productInfo) {
                $productStockInfo = $productInfo['product_current'];
//                $url = config('market_place.sendo.product_info_by_sku') . $productStockInfo->sku;
//                $productInMarket = MarketPlaceTrait::curlAPI($url, $marketPlaceInfo->token, [], 'GET');

                $data = [
                    'item_id' => 0,
                    'avatar' => $avatar,
                    'name' => $productStockInfo->product->name,
                    'sku_id' => $idProductConnecting,
                    'seller_sku' => $productStockInfo->sku,
                    'price' => $productStockInfo->price,
                    'qty' => $productStockInfo->qty,
                    'ecommerce_market_place_id' => $marketPlaceId,
                    'product_stock_id' => $productStockInfo->id,
                ];

                $this->repEcommerceLinkProduct->createLinkProductTogether($data);
            }
        }

        return response_json(true, 'Đồng bộ sản phẩm thành công');

    }

}
