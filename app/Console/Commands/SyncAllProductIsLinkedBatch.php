<?php

namespace App\Console\Commands;

use App\Http\Repository\EcommerceLinkProductRepository;
use App\Http\Repository\EcommerceMarketPlacesRepository;
use Illuminate\Console\Command;

class SyncAllProductIsLinkedBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sync_all_product_is_linked';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var EcommerceLinkProductRepository
     */
    private $repEcommerceLinkProduct;
    /**
     * @var EcommerceMarketPlacesRepository
     */
    private $repEcommerceMarketPlace;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->repEcommerceLinkProduct = new EcommerceLinkProductRepository();
        $this->repEcommerceMarketPlace = new EcommerceMarketPlacesRepository();

    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        //
        $productMarketIdsSynced = $this->repEcommerceLinkProduct->getProductMarketIdsIsSynced();
        $allMarkets = $this->repEcommerceMarketPlace->getAllConnectedMarket();
        foreach ($allMarkets as $marketPlaceInfo) {
            if ($marketPlaceInfo->market_type == config('market_place.market_key.sendo')) {
                $this->repEcommerceMarketPlace->syncSendo($productMarketIdsSynced, $marketPlaceInfo->token);
            }
        }
    }

}
