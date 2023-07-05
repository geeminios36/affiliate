<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DeliveryTenancies extends Model
{
    protected $fillable = [
        'delivery_partner_id',
        'connect_partner_id',
        'status',
        'updated_by',
        'created_by',
        'is_deleted',
        'token_key',
        'tenacy_id',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new \App\Scopes\TenacyScope);

        static::saving(function ($model) {
            $model->tenacy_id = get_tenacy_id_for_query();
            $model->created_by = Auth::user()->id;
        });

    }

    public function delivery_partners()
    {
        return $this->hasOne(DeliveryPartners::class, 'id', 'delivery_partner_id');
    }

    public function scopeWithAndWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }
}
