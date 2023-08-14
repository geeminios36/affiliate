<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BusinessSetting extends Model
{
    protected $fillable = ['type', 'value'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

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

}
