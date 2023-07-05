<?php

namespace App\Jobs;

use App\Http\Repository\EcommerceLinkProductRepository;
use App\Http\Repository\EcommerceMarketPlacesRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncAllProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var EcommerceLinkProductRepository
     */
    private $repEcommerceLinkProduct;
    /**
     * @var EcommerceMarketPlacesRepository
     */
    private $repEcommerceMarketPlace;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $sendoType;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $lazadaType;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->repEcommerceLinkProduct = new EcommerceLinkProductRepository();
        $this->repEcommerceMarketPlace = new EcommerceMarketPlacesRepository();
        $this->sendoType = config('market_place.market_key.sendo');
        $this->lazadaType = config('market_place.market_key.lazada');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $allMarkets = $this->repEcommerceMarketPlace->getMarketWithProducts();
        foreach ($allMarkets as $marketPlaceInfo) {
            $productMarketIdsSynced = $marketPlaceInfo->ecommerce_link_products;
            if ($marketPlaceInfo->market_type == $this->sendoType) {
                $this->repEcommerceMarketPlace->syncSendo($productMarketIdsSynced, $marketPlaceInfo->token);
            } elseif ($marketPlaceInfo->market_type == $this->lazadaType) {
                $this->repEcommerceMarketPlace->syncLazada($productMarketIdsSynced, $marketPlaceInfo->token);
            }
        }
    }
}
