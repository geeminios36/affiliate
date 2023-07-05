<?php

namespace App\Http\Repository;


use App\EcommerceLinkProducts;
use App\Http\Traits\MarketPlaceTrait;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Exception;

class EcommerceLinkProductRepository
{
    /**
     * @var int[]
     */
    private $unit;

    public function __construct()
    {
        $this->model = new EcommerceLinkProducts();
        $this->unit = [
            'cái' => 1,
            'bộ' => 2,
            'chiếc' => 3,
            'đôi' => 4,
            'hộp' => 5,
            'vuốn' => 6,
            'chai' => 7,
            'thùng' => 8,
        ];
    }

    public function getLinkProductByTypeIds($marketPlaceId, $productStockId)
    {
        return $this->model->where('ecommerce_market_place_id', $marketPlaceId)
            ->where('product_stock_id', $productStockId)
            ->where('is_deleted', 0)
            ->select('id', 'ecommerce_market_place_id', 'product_market_place_id', 'product_stock_id')
            ->get();
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
            $this->unit[trim(preg_replace('/\d/', '', $productStockInfo->product->unit))] : $productInMarket->result->unit_id);
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
                $url = config('market_place.sendo.product_info_by_sku') . $productStockInfo->sku;
                $productInMarket = MarketPlaceTrait::curlAPI($url, $token, [], 'GET');
                $productInMarket = json_decode($productInMarket);

                $data = [
                    'item_id' => 0,
                    'avatar' => $productInMarket->result->image,
                    'name' => $productInMarket->result->name,
                    'sku_id' => $productInMarket->result->id,
                    'seller_sku' => $productInMarket->result->sku,
                    'price' => $productInMarket->result->price,
                    'qty' => $productInMarket->result->stock_quantity,
                    'ecommerce_market_place_id' => $marketPlaceId,
                    'product_stock_id' => $productStockInfo->id,
                ];

                self::createLinkProductTogether($data);
            }
        } catch (Exception $exception) {
            dd($exception);
        }

        if ($linkProductTogether->status_code !== 200) {
            return response_json(false, 'Có lỗi xảy ra trong quá trình đồng bộ', $linkProductTogether);
        }

        return response_json(true, 'Đồng bộ sản phẩm thành công');
    }

    /**
     * @return EcommerceLinkProducts
     */
    public function getLinkProductById($productLinkedId)
    {
        return $this->model->where('is_deleted', 0)
            ->whereId($productLinkedId)
            ->first();
    }

    public function getLinkProductsIds($productStockIds, $marketPlaceId)
    {
        return $this->model->where('is_deleted', 0)
            ->whereIn('product_stock_id', $productStockIds)
            ->where('ecommerce_market_place_id', $marketPlaceId)
            ->pluck('id')->toArray();
    }

    public function getLinkProductByVariantId($variantId, $marketPlaceId)
    {
        $syncedProduct = $this->model->where('is_deleted', 0);
        if (is_array($variantId) && count($variantId)) {
            $syncedProduct = $syncedProduct->whereIn('product_market_place_id', $variantId);
        } else {
            $syncedProduct = $syncedProduct->where('product_market_place_id', $variantId);
        }

        $syncedProduct = $syncedProduct->where('ecommerce_market_place_id', $marketPlaceId)
            ->get();
        return $syncedProduct;
    }

    public function getParentIdsLinked($parentIds, $marketPlaceId)
    {
        return $this->model->where('is_deleted', 0)
            ->whereIn('parent_product_market_place_id', $parentIds)
            ->where('ecommerce_market_place_id', $marketPlaceId)
            ->pluck('parent_product_market_place_id')->unique()->toArray();
    }

    public function getProductStockIdsIsSynced($marketPlaceId = null)
    {
        $productLinked = $this->model->where('is_deleted', 0);
        if (!empty($marketPlaceId)) {
            $productLinked = $productLinked
                ->where('ecommerce_market_place_id', (int)$marketPlaceId);
        }

        return $productLinked->pluck('product_stock_id')->toArray();
    }

    public function getProductMarketIdsIsSynced()
    {
        return $this->model
            ->where('is_deleted', 0)
            ->with('ecommerce_market_place')
            ->withAndWhereHas('product_stock', function ($query) {
                $query->with(['product']);
            })
            ->get();
    }

    public function getVariantProductById($inputData)
    {
        return $this->model->where('is_deleted', 0)
            ->where('ecommerce_market_place_id', $inputData['market_id'])
            ->where('product_market_place_id', 'var_' . $inputData['variant_id'])
            ->withAndWhereHas('ecommerce_market_place', function ($q) use ($inputData) {
                $q->where('id', $inputData['market_id'])
                    ->with(['ecommerce_market_place_config']);
            })->first();
    }

    public function createLinkProductTogether($array)
    {
        $productDetail = isset($array['data']) ? $array['data'] : '';
        if (!isset($array['data'])) {
            $productDetail = new \stdClass();
            $result = new  \stdClass();
            $avatar = new  \stdClass();
            $avatar->picture_url = @$array['avatar'];
            $result->id = $array['item_id'];
            $result->name = $array['name'];
            $result->sku = $array['seller_sku'];
            $result->price = $array['price'];
            $result->avatar = $avatar;
            $result->stock_quantity = $array['qty'];
            $productDetail->result = $result;
        }

        $updateData = [
            'ecommerce_market_place_id' => $array['ecommerce_market_place_id'],
            'parent_product_market_place_id' => $array['item_id'],
            'product_market_place_id' => 'var_' . $array['sku_id'],
            'product_stock_id' => $array['product_stock_id'],
        ];

        EcommerceLinkProducts::where('is_deleted', 0)->updateOrCreate($updateData, [
            'ecommerce_market_place_id' => $array['ecommerce_market_place_id'],
            'parent_product_market_place_id' => $array['item_id'],
            'product_market_place_id' => 'var_' . $array['sku_id'],
            'product_stock_id' => $array['product_stock_id'],
            'product_detail' => json_encode($productDetail),
        ]);
    }
}
