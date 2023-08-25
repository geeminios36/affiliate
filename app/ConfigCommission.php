<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigCommission extends Model
{
    protected static function boot()
    {
        parent::boot();

        if(is_using_tenacy_id()) {
            static::addGlobalScope(new \App\Scopes\TenacyScope);
        }
    }
}
