<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FlashDeal
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $start_date
 * @property int|null $end_date
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FlashDeal extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \App\Scopes\TenacyScope);

        // Doc: https://viblo.asia/p/su-dung-model-observers-trong-laravel-oOVlYeQVl8W
        static::saving(function ($model) {
            $model->tenacy_id = get_tenacy_id_for_query();
        });
    }
    
    public function flashDealProducts()
    {
        return $this->hasMany(FlashDealProduct::class);
    }
}
