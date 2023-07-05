<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App;

class SellerPackage extends Model
{
    protected $guarded = [];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new \App\Scopes\TenacyScope);

        // Doc: https://viblo.asia/p/su-dung-model-observers-trong-laravel-oOVlYeQVl8W
        static::saving(function ($model) {
            $model->tenacy_id = get_tenacy_id_for_query();
        });
        
    }

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query->where('tenacy_id', get_tenacy_id_for_query())->where('id', $this->id);

        return $query;
    }

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $seller_package_translation = $this->hasMany(SellerPackageTranslation::class)->where('lang', $lang)->first();
        return $seller_package_translation != null ? $seller_package_translation->$field : $this->$field;
    }

    public function seller_package_translations(){
      return $this->hasMany(SellerPackageTranslation::class);
    }

    public function seller_package_payments()
    {
        return $this->hasMany(SelllerPackagePayment::class);
    }

}
