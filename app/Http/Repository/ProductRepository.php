<?php

namespace App\Http\Repository;

use App\Product;
use App\ProductStock;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function __construct()
    {
        $this->model = new Product();
    }

    public function getAllProducts()
    {
        $productsCurrent = DB::table('products')
            ->where('tenacy_id', env('TENACY_ID'))
            ->get();

        return $productsCurrent;
    }

    public function getPaginateProductStock($inputData = [], $page = 1)
    {
        $productsCurrent = ProductStock::whereNotNull('sku')
            ->with('linked_market_products');

        if (!empty($inputData['keyword'])) {
            $productsCurrent = $productsCurrent->where(function ($q) use ($inputData) {
                $q->where("sku", "like", "%" . $inputData['keyword'] . "%")->orWhere(function ($q) use ($inputData) {
                    $q->withAndWhereHas('product', function ($q) use ($inputData) {
                        $q->where("products.name", "like", "%" . $inputData['keyword'] . "%");
                    });
                });

            });
        } else {
            $productsCurrent = $productsCurrent->withAndWhereHas('product', function ($q) use ($inputData) {

            });
        }

        if (!empty($inputData['status'])) {
            if ($inputData['status'] == 1) {
                $productsCurrent = $productsCurrent->doesntHave('linked_market_products');
            } elseif ($inputData['status'] == 2) {
                $productsCurrent = $productsCurrent->withAndWhereHas('linked_market_products', function ($q) {

                });
            }
        }

        $productsCurrent = $productsCurrent->paginate(50, ['*'], 'page', $page);

        return $productsCurrent;
    }
}
