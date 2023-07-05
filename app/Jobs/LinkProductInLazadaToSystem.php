<?php

namespace App\Jobs;

use App\EcommerceLinkProducts;
use App\Http\Repository\lazadaRepsitory;
use App\LazadaLib\lazop\LazopClient;
use App\LazadaLib\lazop\LazopRequest;
use App\LazadaLib\lazop\UrlConstants;
use App\ProductStock;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LinkProductInLazadaToSystem implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $marketPlaceInfo;
    private $variantHashs;
    /**
     * @var lazadaRepsitory
     */
    private $repLazada;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $appkey;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $app_secret;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($variantHashs, $marketPlaceInfo)
    {
        //
        $this->marketPlaceInfo = $marketPlaceInfo;
        $this->variantHashs = $variantHashs;
        $this->repLazada = new lazadaRepsitory();
        $this->appkey = config('market_place.lazada.client_id');
        $this->app_secret = config('market_place.lazada.secret_key');


    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!count($this->variantHashs)) {
            $this->handleAllProducts();
            return;
        }

        $addParent = collect();
        foreach ($this->variantHashs as $variantHashInfo) {
            $arrayData = explode('_var_', $variantHashInfo);;
            $addParent->push([
                'parent_id' => $arrayData[0],
                'variant_id' => $arrayData[1],
            ]);
        }

        $addParent = $addParent->groupBy('parent_id');
        $client = new LazopClient(UrlConstants::$api_gateway_url_vn, $this->appkey, $this->app_secret);
        foreach ($addParent as $productId => $childIds) {
            $childIdArray = $childIds->pluck('variant_id')->toArray();

            $request = new LazopRequest(config('market_place.lazada.product_info_by_sku'), 'GET');
            $request->addApiParam('item_id', $productId);
            $productInMarket = $client->execute($request, $this->marketPlaceInfo->token);
            $productInMarket = json_decode($productInMarket);
            if (!isset($productInMarket->data))
                continue;

            $variants = collect($productInMarket->data->skus)->whereIn('SkuId', $childIdArray);

            $variantSellerSkus = $variants->pluck('SellerSku')->toArray();

            $productStockData = ProductStock::whereIn('sku', $variantSellerSkus)->with('product')->get();
            if (!count($productStockData))
                continue;

            $this->repLazada->linkDataInMarketToSystem($variants, $productStockData, $productInMarket->data, $productId, $this->marketPlaceInfo);
        }
    }

    public function handleAllProducts()
    {
        $listProducts = $this->repLazada->getProductList($this->marketPlaceInfo->token);

        foreach ($listProducts as $productInMarket) {
            $variants = collect($productInMarket->skus);

            $variantSellerSkus = $variants->pluck('SellerSku')->toArray();

            $productStockData = ProductStock::whereIn('sku', $variantSellerSkus)->with('product')->get();
            if (!count($productStockData))
                continue;

            $this->repLazada->linkDataInMarketToSystem($variants, $productStockData, $productInMarket, $productInMarket->item_id, $this->marketPlaceInfo);
        }
    }

}
