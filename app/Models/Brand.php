<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Brand
 *
 * @property int $id
 * @property string $name
 * @property string|null $logo
 * @property int $top
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Brand extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('alphabetical', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });

        static::addGlobalScope(new \App\Scopes\TenacyScope);

        // Doc: https://viblo.asia/p/su-dung-model-observers-trong-laravel-oOVlYeQVl8W
        static::saving(function ($model) {
            $model->tenacy_id = get_tenacy_id_for_query();
        });
    }
}
