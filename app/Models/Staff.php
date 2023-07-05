<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Staff
 *
 * @property int $id
 * @property int $user_id
 * @property int $role_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staff query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staff whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staff whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Staff whereUserId($value)
 * @mixin \Eloquent
 */
class Staff extends Model
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
}
