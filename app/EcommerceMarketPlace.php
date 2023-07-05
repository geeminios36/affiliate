<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EcommerceMarketPlace extends Model
{
    //
    protected $fillable = ['connection_info', 'market_type', 'status', 'token', 'created_by', 'logo', 'market_id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new \App\Scopes\TenacyScope);

        static::saving(function ($model) {
            $model->tenacy_id = get_tenacy_id_for_query();
            $model->updated_by = Auth::user()->id;
        });

    }

    public function ecommerce_market_place_config()
    {
        return $this->hasOne(EcommerceMarketPlaceConfig::class, 'ecommerce_market_place_id', 'id')
            ->where('is_deleted', 0);
    }

    public function ecommerce_link_products()
    {
        return $this->hasMany(EcommerceLinkProducts::class, 'ecommerce_market_place_id', 'id')
            ->where('is_deleted', 0);
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
}
