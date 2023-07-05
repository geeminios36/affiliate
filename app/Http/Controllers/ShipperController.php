<?php

namespace App\Http\Controllers;

use App\DeliveryTenancies;
use App\Http\Repository\OrderRepository;
use App\Http\Traits\DeliveryTenancyTrait;
use Illuminate\Http\Request;

class ShipperController extends Controller
{
    //
    use DeliveryTenancyTrait;

    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $ghn_status_order;
    /**
     * @var OrderRepository
     */
    private $repOrder;

    public function __construct()
    {
        $this->repOrder = new OrderRepository();
        $this->ghn_status_order = config('constants.ghn_status_order');
        $this->ghtk_status_order = config('constants.ghtk_status_order');
    }

    public function shippers($delivery_tenancies_id)
    {
        $deliveryTenancy = DeliveryTenancyTrait::getDeliveryTenancyById($delivery_tenancies_id);
        $code = $deliveryTenancy->delivery_partners->code;

        $orders = $this->repOrder->getDataDelivery($deliveryTenancy, $delivery_tenancies_id, $code);
        $shippingAddress = $orders->pluck('shipping_address')
            ->groupBy('status_delivery');

        $isProcessing = 0;
        if ($code == config('constant.ghn')) {
            $isProcessing = isset($shippingAddress['picking']) ? count($shippingAddress['picking']) : 0;
        }elseif($code == config('constant.ghtk')){
            $isProcessing = isset($shippingAddress['2']) ? count($shippingAddress['2']) : 0;
        }

        return view('backend.delivery.shippers.index', compact('deliveryTenancy', 'orders', 'isProcessing'));
    }
}
