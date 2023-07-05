<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ProductCollection;
use App\Models\FlashDeal;
use App\Models\Product;

class FlashDealCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $flash_deal = FlashDeal::where('id', $this->collection->first()->id)->first();
        $products = collect();
        foreach ($flash_deal->flashDealProducts as $key => $flash_deal_product) {
            if(Product::where('id',$flash_deal_product->product_id)->first() != null){
                    $products->push(Product::where('id',$flash_deal_product->product_id)->first());
            }
        }
        return [
            'title' => $flash_deal->title,
            'end_date' => $flash_deal->end_date,
            'products' => new ProductCollection($products)
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
