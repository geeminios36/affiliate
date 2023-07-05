<?php

namespace App\Jobs;

use App\EcommerceLinkProducts;
use App\Http\Repository\EcommerceMarketPlacesRepository;
use App\Http\Repository\SendoRepository;
use App\Http\Traits\MarketPlaceTrait;
use App\ProductStock;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LinkProductInSendoToSystem implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $marketPlaceInfo;
    private $variantHashs;
    /**
     * @var EcommerceMarketPlacesRepository
     */
    private $repEcommerceMarketPlace;
    /**
     * @var SendoRepository
     */
    private $sendoRepo;

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
        $this->sendoRepo = new SendoRepository();
        $this->repEcommerceMarketPlace = new EcommerceMarketPlacesRepository();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
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

        $this->sendoRepo->linkMultiProductInMarketToSystem($addParent, $this->marketPlaceInfo);
    }

    public function handleAllProducts()
    {
        $type_market = config('market_place.type_market')[$this->marketPlaceInfo->market_type];

        $listProducts = $this->repEcommerceMarketPlace->getSendoProductList($this->marketPlaceInfo->token, $type_market, true);
        $listProductIds = $listProducts->pluck('id');

        foreach ($listProductIds as $productId) {
            $url = config('market_place.sendo.product_info_by_id') . $productId;
            $productParentInfo = MarketPlaceTrait::curlAPI($url, $this->marketPlaceInfo->token, [], 'GET');
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

                if (!empty($productStockInfo)) {
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

            $ItemIds[$productId] = $productStockArray;
            $data[] = $this->sendoRepo->getDataToUpdate($productId, $productParentInfo, $variants->sum('variant_quantity'), $variants->toArray());
        }

        $urlUpdateProduct = config('market_place.sendo.update_or_create_multi_products');

        $linkProductTogether = MarketPlaceTrait::curlAPI($urlUpdateProduct, $this->marketPlaceInfo->token, json_encode($data));

        $linkProductTogether = json_decode($linkProductTogether);
        if ($linkProductTogether->status_code == 200 && !count($linkProductTogether->result->error_list)) {
            $this->sendoRepo->updateOrCreateLinkMarket($ItemIds, $this->marketPlaceInfo);
        }
    }

}
