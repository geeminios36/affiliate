<?php

namespace App\Jobs;

use App\Http\Repository\EcommerceMarketPlacesRepository;
use App\Http\Repository\lazadaRepsitory;
use App\Http\Repository\SendoRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncAllProductInMarket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
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
     * @var SendoRepository
     */
    private $sendoRepo;
    /**
     * @var lazadaRepsitory
     */
    private $lazadaRepo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repEcommerceMarketPlace = new EcommerceMarketPlacesRepository();
        $this->sendoType = config('market_place.market_key.sendo');
        $this->lazadaType = config('market_place.market_key.lazada');
        $this->sendoRepo = new SendoRepository();
        $this->lazadaRepo = new lazadaRepsitory();
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
                $this->sendoRepo->syncProductInMarketToSystem($productMarketIdsSynced, $marketPlaceInfo);
            } elseif ($marketPlaceInfo->market_type == $this->lazadaType) {
                $this->lazadaRepo->syncProductInMarketToSystem($productMarketIdsSynced, $marketPlaceInfo);
            }
        }
    }
}
