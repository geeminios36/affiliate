<?php

namespace App\Http\Repository;

use App\EcommerceLinkProducts;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\MarketPlaceTrait;

class TikiRepository
{
    /**
     * @var EcommerceLinkProductRepository
     */
    private $repLinkProduct;

    public function __construct()
    {
        $this->repLinkProduct = new EcommerceLinkProductRepository();
    }

    public function linkProduct($marketPlaceInfo, $productStockInfo) {
		$object = [
			'original_sku' => $productStockInfo->sku,
			'price' => $productStockInfo->price,
			'quantity' => $productStockInfo->qty,
		];

		$urlUpdateProduct = config('market_place.tiki.update_price_and_quantity');
		$linkProductTogether = MarketPlaceTrait::curlAPI($urlUpdateProduct, $marketPlaceInfo->token, json_encode($object));

		$linkProductTogether = json_decode($linkProductTogether);
		if (isset($linkProductTogether->state) && $linkProductTogether->state == 'approved') {
			$url = config('market_place.tiki.product_info_by_sku') . $productStockInfo->sku;
            $productInMarket = MarketPlaceTrait::curlAPI($url, $marketPlaceInfo->token, [], 'GET');
            $productInMarket = json_decode($productInMarket);

            /*$productDetail = new \stdClass();
            $result = new  \stdClass();
            $avatar = new  \stdClass();
            $avatar->picture_url = $productInMarket->thumbnail;
            $result->id = $productInMarket->product_id;
            $result->name = $productInMarket->name;
            $result->sku = $productInMarket->original_sku;
            $result->price = $productInMarket->price;
            $result->avatar = $avatar;
            $result->stock_quantity = $productInMarket->inventory->quantity;
            $productDetail->result = $result;

            $array = [
                'ecommerce_market_place_id' => $marketPlaceInfo->id,
                'product_market_place_id' => $productInMarket->product_id,
                'product_stock_id' => $productStockInfo->id,
            ];

            $createLinkProduct = EcommerceLinkProducts::where('is_deleted', 0)->updateOrCreate($array, [
                'ecommerce_market_place_id' => $marketPlaceInfo->id,
                'product_market_place_id' => $productInMarket->product_id,
                'product_stock_id' => $productStockInfo->id,
                'product_detail' => json_encode($productDetail),
                'updated_by' => Auth::user()->id,
            ]);*/
            $data = [
                'item_id' => 0,
                'avatar' => $productInMarket->thumbnail,
                'name' => $productInMarket->name,
                'sku_id' => $productInMarket->product_id,
                'seller_sku' => $productInMarket->original_sku,
                'price' => $productInMarket->price,
                'qty' => $productInMarket->inventory->quantity,
                'ecommerce_market_place_id' => $marketPlaceInfo->id,
                'product_stock_id' => $productStockInfo->id,
            ];

            $this->repLinkProduct->createLinkProductTogether($data);

            if($productInMarket->inventory->inventory_type == 'instock'){
		  		return response_json(true, 'Liên kết sản phẩm thành công. Không thể cập nhật số lượng sản phẩm có loại kho instock');
            }

		  	return response_json(true, 'Liên kết sản phẩm thành công');
        }

        return response_json(false, 'Không tồn tại sản phẩm có mã sku này');
	}
}
