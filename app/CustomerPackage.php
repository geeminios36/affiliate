<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App;

class CustomerPackage extends Model
{
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
      $brand_translation = $this->hasMany(CustomerPackageTranslation::class)->where('lang', $lang)->first();
      return $brand_translation != null ? $brand_translation->$field : $this->$field;
    }

    public function customer_package_translations(){
      return $this->hasMany(CustomerPackageTranslation::class);
    }

    public function customer_package_payments()
    {
        return $this->hasMany(CustomerPackagePayment::class);
    }

}
