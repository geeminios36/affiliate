<?php

namespace App\Jobs;

use App\EcommerceLinkProducts;
use App\Http\Repository\EcommerceLinkProductRepository;
use App\Http\Repository\EcommerceMarketPlacesRepository;
use App\Http\Repository\lazadaRepsitory;
use App\Http\Repository\ProductRepository;
use App\Http\Repository\ProductStockRepository;
use App\LazadaLib\lazop\LazopClient;
use App\LazadaLib\lazop\LazopRequest;
use App\LazadaLib\lazop\UrlConstants;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class LinkAllProductLazadaById implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $marketPlaceInfo;
    private $marketPlaceId;
    private $productStockIds;
    private $token;
    private $market_type;
    /**
     * @var mixed
     */
    private $typeMarket;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $sendoType;
    /**
     * @var ProductStockRepository
     */
    private $repProductStock;
    /**
     * @var lazadaRepsitory
     */
    private $repLazada;
    /**
     * @var EcommerceLinkProductRepository
     */
    private $repLinkProduct;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($productStockIds, $marketPlaceInfo)
    {
        //
        $this->marketPlaceInfo = $marketPlaceInfo;
        $this->marketPlaceId = $this->marketPlaceInfo->id;
        $this->productStockIds = $productStockIds;
        $this->token = $this->marketPlaceInfo->token;
        $this->market_type = $this->marketPlaceInfo->market_type;
        $this->typeMarket = config('market_place.type_market')[$this->marketPlaceInfo->market_type];
        $this->sendoType = config('market_place.market_key.sendo');
        $this->repProductStock = new ProductStockRepository();
        $this->repLazada = new lazadaRepsitory();
        $this->repLinkProduct = new EcommerceLinkProductRepository();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $listProducts = $this->repLazada->getProductList($this->token);
        $skuArray = $listProducts->pluck('skus')->flatten()
            ->pluck('SellerSku')->filter()
            ->unique()->toArray();

        if (!count($this->productStockIds)) {
            $productStockData = $this->repProductStock->getProductStocksHasSkuNotSynced($this->marketPlaceId, $skuArray);
        } else {
            $productStockData = $this->repProductStock->getProductsStockByIds($this->productStockIds, $skuArray);
        }

        $appkey = config('market_place.lazada.client_id');
        $app_secret = config('market_place.lazada.secret_key');

        if (count($productStockData)) {
            foreach ($productStockData as $productStockInfo) {
                $client = new LazopClient(UrlConstants::$api_gateway_url_vn, $appkey, $app_secret);
                $request = new LazopRequest(config('market_place.lazada.product_info_by_sku'), 'GET');
                $request->addApiParam('seller_sku', $productStockInfo->sku);
                $productInMarket = $client->execute($request, $this->token);
                $productInMarket = json_decode($productInMarket);
                if (!isset($productInMarket->data))
                    continue;

                $productInMarket = $productInMarket->data;
                $payload = '<?xml version="1.0" encoding="UTF-8" ?>
                     <Request>
                       <Product>
                          <ItemId>' . $productInMarket->item_id . '</ItemId>
                          <Attributes>
                             <name>' . $productInMarket->attributes->name . '</name>
                             <short_description>' . $productInMarket->attributes->description . '</short_description>
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
                $client->execute($request, $this->token);


                $data = [
                    'item_id' => $productInMarket->item_id,
                    'avatar' => uploaded_asset($productStockInfo->product->thumbnail_img),
                    'name' => $productInMarket->attributes->name,
                    'sku_id' => $productInMarket->skus[0]->SkuId,
                    'seller_sku' => $productInMarket->skus[0],
                    'price' => $productStockInfo->price,
                    'qty' => $productStockInfo->qty,
                    'ecommerce_market_place_id' => $this->marketPlaceId,
                    'product_stock_id' => $productStockInfo->id,
                ];

                $this->repLinkProduct->createLinkProductTogether($data);
            }
        }
    }

}
