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
    protected $guarded = [];
    protected $fillable = ['user_id', 'role_id', 'tenacy_id'];
    protected static function boot()
    {
        parent::boot();

        if(is_using_tenacy_id()) {
            static::addGlobalScope(new \App\Scopes\TenacyScope);
        }
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
