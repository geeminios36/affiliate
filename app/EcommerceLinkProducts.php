<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EcommerceLinkProducts extends Model
{
    protected $fillable = [
        'ecommerce_market_place_id',
        'parent_product_market_place_id',
        'product_market_place_id',
        'product_stock_id',
        'product_detail',
        'created_by',
        'updated_at',
        'updated_by',
        'is_deleted'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \App\Scopes\TenacyScope);

        static::saving(function ($model) {
            $model->tenacy_id = get_tenacy_id_for_query();
            $model->created_by = !empty(Auth::user()) ? Auth::user()->id : 0;
        });
    }

    /**
     * @param $query
     * @param $relation
     * @param $constraint
     * @return mixed
     */
    public function scopeWithAndWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product_stock()
    {
        return $this->belongsTo(ProductStock::class, 'product_stock_id', 'id');
    }
    public function ecommerce_market_place()
    {
        return $this->belongsTo(EcommerceMarketPlace::class, 'ecommerce_market_place_id', 'id');
    }
}
