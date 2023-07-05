<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EcommerceMarketPlaceConfig extends Model
{
    //
    protected $fillable = [
        'ecommerce_market_place_id',
        'shorted_name',
        'use_code_order',
        'sync_inventory',
        'sync_price',
        'status_sold',
        'policy_price',
        'sync_inventory_branch_to_store',
        'branch_receives_order',
        'order_officer',
        'created_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new \App\Scopes\TenacyScope);

        static::saving(function ($model) {
            $model->tenacy_id = get_tenacy_id_for_query();
            $model->updated_by = Auth::user()->id;
        });

    }

}
