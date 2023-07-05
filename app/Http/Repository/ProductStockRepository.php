<?php

namespace App\Http\Repository;

use App\ProductStock;

class ProductStockRepository
{
    public function __construct()
    {
        $this->model = new ProductStock();
    }

    /**
     * @return ProductStock
     */
    public function getProductStockById($id)
    {
        return $this->model->with(['product', 'linked_market_products'])
            ->whereId($id)
            ->first();
    }

    public function getProductStockBySku($sku)
    {
        return $this->model->with(['product', 'linked_market_products'])
            ->where('sku', $sku)
            ->first();
    }

    public function getProductsStockByIds($ids, $skuArray = [])
    {
        $productStocks = $this->model->with(['product', 'linked_market_products'])
            ->whereIn('id', $ids);

        if (count($skuArray)) {
            $productStocks = $productStocks->whereIn('sku', $skuArray);
        }

        return $productStocks->get();
    }


    public function getProductStocksHasSkuNotSynced($marketPlaceId, $skuArray = [])
    {
        $productStocks = $this->model->with(['product'])
            ->whereNotNull('sku')
            ->with(['linked_market_products']);
        if (count($skuArray)) {
            $productStocks = $productStocks->whereIn('sku', $skuArray);
        }

        $productStocks = $productStocks->get()->filter(function ($q) use ($marketPlaceId) {
            if (count($q->linked_market_products)) {
                return count($q->linked_market_products->where('ecommerce_market_place_id', $marketPlaceId)) == 0;
            }

            return $q;
        });

        return $productStocks;
    }

}
