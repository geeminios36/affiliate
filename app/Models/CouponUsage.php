<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CouponUsage
 *
 * @property int $id
 * @property int $user_id
 * @property int $coupon_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponUsage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponUsage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponUsage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponUsage whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponUsage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponUsage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponUsage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponUsage whereUserId($value)
 * @mixin \Eloquent
 */
class CouponUsage extends Model
{
    protected $guarded = [];
    
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \App\Scopes\TenacyScope);

        // Doc: https://viblo.asia/p/su-dung-model-observers-trong-laravel-oOVlYeQVl8W
        static::saving(function ($model) {
            $model->tenacy_id = get_tenacy_id_for_query();
        });
    }
}
