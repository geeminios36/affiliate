<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderDetail
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $seller_id
 * @property int $product_id
 * @property string|null $variation
 * @property float|null $price
 * @property float $tax
 * @property float $shipping_cost
 * @property int|null $quantity
 * @property string $payment_status
 * @property string|null $delivery_status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereDeliveryStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereShippingCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderDetail whereVariation($value)
 * @mixin \Eloquent
 */

class OrderDetail extends Model
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

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
