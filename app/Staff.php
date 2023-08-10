<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Staff extends Model
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
//        static::saving(function ($model) {
//            $model->tenacy_id1 = get_tenacy_id_for_query();
//            $model->save();
//        });
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
    
    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function role()
    {
    return $this->belongsTo(Role::class);
    }

    public function pick_up_point()
    {
    	return $this->hasOne(PickupPoint::class);
    }

}
