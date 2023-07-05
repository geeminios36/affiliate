<?php

namespace App\Jobs;

use App\EcommerceLinkProducts;
use App\Http\Repository\EcommerceLinkProductRepository;
use App\Http\Repository\EcommerceMarketPlacesRepository;
use App\Http\Repository\ProductRepository;
use App\Http\Repository\ProductStockRepository;
use App\Http\Repository\SendoRepository;
use App\Http\Traits\MarketPlaceTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Exception;

class LinkAllProductById implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ProductStockRepository
     */
    private $repProductStock;
    /**
     * @var EcommerceLinkProductRepository
     */
    private $repEcommerceLinkProduct;
    private $marketPlaceId;
    private $token;
    private $market_type;
    private $productStockIds;
    private $marketPlaceInfo;
    /**
     * @var EcommerceMarketPlacesRepository
     */
    private $repEcommerceMarketPlace;
    /**
     * @var mixed
     */
    private $typeMarket;
    /**
     * @var ProductRepository
     */
    private $repProduct;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $sendoType;
    /**
     * @var SendoRepository
     */
    private $repSendo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($productStockIds, $marketPlaceInfo)
    {
        //
        $this->repProductStock = new ProductStockRepository();
        $this->repEcommerceLinkProduct = new EcommerceLinkProductRepository();
        $this->marketPlaceInfo = $marketPlaceInfo;
        $this->marketPlaceId = $this->marketPlaceInfo->id;
        $this->productStockIds = $productStockIds;
        $this->token = $this->marketPlaceInfo->token;
        $this->market_type = $this->marketPlaceInfo->market_type;
        $this->typeMarket = config('market_place.type_market')[$this->marketPlaceInfo->market_type];
        $this->repEcommerceMarketPlace = new EcommerceMarketPlacesRepository();
        $this->repProduct = new ProductRepository();
        $this->sendoType = config('market_place.market_key.sendo');
        $this->repSendo = new SendoRepository();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!count($this->productStockIds)) {
            $this->handleAllProducts();
            return;
        }

        $productStocks = $this->repProductStock->getProductsStockByIds($this->productStockIds);
        foreach ($productStocks as $productStockInfo) {
            if (!empty($productStockInfo) && $this->market_type == config('market_place.market_key.sendo')) {
                $url = config('market_place.sendo.product_info_by_sku') . $productStockInfo->sku;
                $productInMarket = MarketPlaceTrait::curlAPI($url, $this->token, [], 'GET');
                $productInMarket = json_decode($productInMarket);
                $idProductConnecting = @$productInMarket->result->id;

                if (!empty($idProductConnecting)) {
                    $data = [
                        'id' => $idProductConnecting,
                        'token' => $this->token,
                        'url' => config('market_place.sendo.update_or_create_product'),
                        'ecommerce_market_place_d' => $this->marketPlaceId,
                        'product_in_market' => $productInMarket,
                        'product_current' => $productStockInfo
                    ];

                    $this->repSendo->linkOneProductToMarket($data);
                }
            }
        }
    }

    public function handleAllProducts()
    {
        //
        $listProducts = $this->repEcommerceMarketPlace->getSendoProductList($this->token, $this->typeMarket);
        $productStocks = $this->repProductStock->getProductStocksHasSkuNotSynced($this->marketPlaceInfo->id);
        $productStockIds = $productStocks->pluck('id', 'sku')->toArray();

        $listData = [];
        foreach ($listProducts as $listProductInfo) {
            if (isset($productStockIds[$listProductInfo->sku])) {
                $productStockId = $productStockIds[$listProductInfo->sku];
                $productStockInfo = $productStocks->where('id', $productStockId)->first();
                $url = config('market_place.sendo.product_info_by_sku') . $productStockInfo->sku;
                $productInMarket = MarketPlaceTrait::curlAPI($url, $this->token, [], 'GET');
                $listData[$listProductInfo->id] = [
                    'product_current' => $productStockInfo,
                    'product_in_market' => json_decode($productInMarket),
                ];
            }
        }

        $this->repSendo->syncMultiProductToMarket($this->marketPlaceInfo, $listData);
    }


}
