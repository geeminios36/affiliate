<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DeliveryPartners extends Model
{
    //
    public function delivery_tenancy()
    {
        return $this->hasOne(DeliveryTenancies::class, 'delivery_partner_id', 'id')
            ->where('tenacy_id', Auth::user()->tenacy_id)
            ->where('is_deleted', 0)->orderBy('id', 'desc');
    }

    public function scopeWithAndWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }
}
