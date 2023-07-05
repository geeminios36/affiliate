<?php

namespace App\Models;

use App\User;
use App\Address;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
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

    protected $guarded = [];
    protected $fillable = ['address_id','price','tax','shipping_cost','discount','coupon_code','coupon_applied','quantity','user_id','owner_id','product_id','variation'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
