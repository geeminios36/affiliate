<?php

namespace App\Http\Controllers;

use App\DeliveryPartners;
use App\DeliveryTenancies;
use App\Http\Repository\OrderRepository;
use App\Http\Traits\DeliveryTenancyTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\OTPVerificationController;
use App\Http\Controllers\ClubPointController;
use App\Http\Controllers\AffiliateController;
use App\Order;
use App\Cart;
use App\Address;
use App\Product;
use App\ProductStock;
use App\CommissionHistory;
use App\Color;
use App\OrderDetail;
use App\CouponUsage;
use App\Coupon;
use App\OtpConfiguration;
use App\User;
use App\BusinessSetting;
use Auth;
use Session;
use DB;
use Mail;
use App\Mail\InvoiceEmailManager;
use CoreComponentRepository;
use App\Utility\SmsUtility;
use function GuzzleHttp\json_decode;

class OrderController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $repOrder;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $ghn_status_order;

    /**
     *
     */
    public function __construct()
    {
        $this->ghn_status_order = config('constants.ghn_status_order');
        $this->repOrder = new OrderRepository();
    }

    /**
     * Display a listing of the resource to seller.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $orders = DB::table('orders')
            ->orderBy('code', 'desc')
//                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('seller_id', Auth::user()->id)
            ->select('orders.id')
            ->distinct();

        if ($request->payment_status != null) {
            $orders = $orders->where('payment_status', $request->payment_status);
            $payment_status = $request->payment_status;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }

        $orders = $orders->paginate(15);

        foreach ($orders as $key => $value) {
            $order = \App\Order::where('id', $value->id)->first();
            $order->viewed = 1;
            $order->tenacy_id = get_tenacy_id_for_query();
            $order->save();
        }

        return view('frontend.user.seller.orders', compact('orders', 'payment_status', 'delivery_status', 'sort_search'));
    }

    // All Orders
    public function all_orders(Request $request)
    {
        //CoreComponentRepository::instantiateShopRepository();

        $date = $request->date;
        $sort_search = null;
        $delivery_status = null;

        $orders = Order::orderBy('code', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($date != null) {
            $orders = $orders->where('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->where('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }
        $orders = $orders->paginate(15);
        return view('backend.sales.all_orders.index', compact('orders', 'sort_search', 'delivery_status', 'date'));
    }

    public function all_orders_show($id)
    {
        $order = Order::where('id', decrypt($id))->first();
        $order_shipping_address = json_decode($order->shipping_address);
        $fee = @$order_shipping_address->fee;
        $shippingFee = isset($order_shipping_address->payment_type_id) && $order_shipping_address->payment_type_id == 2 ? preg_replace('/\D/', '', $fee) : 0;
        $delivery_partner_id = @$order_shipping_address->delivery_partner_id;
        $deliveryPartner = empty($delivery_partner_id) ? '' : DeliveryPartners::find($delivery_partner_id);

        $deliveryTenancy = isset($order_shipping_address->delivery_tenancy_id) ? DeliveryTenancies::find($order_shipping_address->delivery_tenancy_id) : '';

        $status_delivery = '';
        if (isset($order_shipping_address->order_code)) {
             $config = config('api_delivery_partner.' . $deliveryPartner->code . '.order_detail');

            $method = 'GET';
            $data = [];
            $delivery_status = '';
            if ($deliveryPartner->code == config('constants.ghn')) {
                $data = ['order_code' => $order_shipping_address->order_code];
                $response = DeliveryTenancyTrait::curlApi(@$deliveryTenancy->token_key, $config, $method, $data);

                $status = @json_decode($response)->data->status;
                $status_delivery = @$this->ghn_status_order[$status];
                $order_shipping_address->status_delivery = @json_decode($response)->data->status;
                $order->shipping_address = json_encode($order_shipping_address);

                if ($status == 'cancel') {
                    $delivery_status = 'cancelled';
                } elseif ($status == 'picked') {
                    $delivery_status = 'picked_up';
                } elseif ($status == 'delivering') {
                    $delivery_status = 'on_the_way';
                } elseif ($status == 'delivered') {
                    $delivery_status = 'delivered';
                }
            } elseif ($deliveryPartner->code == config('constants.ghtk')) {
                $config = $config . $order_shipping_address->order_code->label;
                $response = DeliveryTenancyTrait::curlApi(@$deliveryTenancy->token_key, $config, $method, $data);

                $order_code = collect($order_shipping_address->order_code);
                $status = json_decode($response)->order->status;
                $status_delivery = config('constants.ghtk_status_order')[$status];

                $order_code['status_id'] = $status;

                $order_shipping_address->order_code = $order_code->toArray();
                $order_shipping_address->status_delivery = $status;
                $order->shipping_address = json_encode($order_shipping_address);

                if ((int)$status == -1) {
                    $delivery_status = 'cancelled';
                } elseif ((int)$status == 3) {
                    $delivery_status = 'picked_up';
                } elseif ((int)$status == 4) {
                    $delivery_status = 'on_the_way';
                } elseif ((int)$status == 5) {
                    $delivery_status = 'delivered';
                }
            }

            if (!empty($delivery_status)) {
                $order->delivery_status = $delivery_status;
            }

            $order->save();
        }

        $delivery_boys = [];
        if (isset($order_shipping_address->city)) {
            $delivery_boys = User::where('city', $order_shipping_address->city)
                ->where('user_type', 'delivery_boy')
                ->get();
        }

        return view('backend.sales.all_orders.show', compact('order', 'delivery_boys', 'deliveryPartner', 'status_delivery', 'shippingFee'));
    }

    // Inhouse Orders
    public function admin_orders(Request $request)
    {
        //CoreComponentRepository::instantiateShopRepository();

        $date = $request->date;
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $admin_user_id = User::where('user_type', 'admin')->first()->id;
        $orders = DB::table('orders')
            ->orderBy('code', 'desc')
//                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('seller_id', $admin_user_id)
            ->select('orders.id')
            ->distinct();

        if ($request->payment_type != null) {
            $orders = $orders->where('payment_status', $request->payment_type);
            $payment_status = $request->payment_type;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }
        if ($date != null) {
            $orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }

        $orders = $orders->paginate(15);
        return view('backend.sales.inhouse_orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search', 'admin_user_id', 'date'));
    }

    public function show($id)
    {
        $order = Order::where('id', decrypt($id))->first();
        $order->viewed = 1;
        $order->tenacy_id = get_tenacy_id_for_query();
        $order->save();
        return view('backend.sales.inhouse_orders.show', compact('order'));
    }

    // Seller Orders
    public function seller_orders(Request $request)
    {
        //CoreComponentRepository::instantiateShopRepository();

        $date = $request->date;
        $seller_id = $request->seller_id;
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $admin_user_id = User::where('user_type', 'admin')->first()->id;
        $orders = DB::table('orders')
            ->orderBy('code', 'desc')
//                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('orders.seller_id', '!=', $admin_user_id)
            ->select('orders.id')
            ->distinct();

        if ($request->payment_type != null) {
            $orders = $orders->where('orders.payment_status', $request->payment_type);
            $payment_status = $request->payment_type;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }
        if ($date != null) {
            $orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }
        if ($seller_id) {
            $orders = $orders->where('seller_id', $seller_id);
        }

        $orders = $orders->paginate(15);
        return view('backend.sales.seller_orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search', 'admin_user_id', 'seller_id', 'date'));
    }

    public function seller_orders_show($id)
    {
        $order = Order::where('id', decrypt($id))->first();
        $order->viewed = 1;
        $order->tenacy_id = get_tenacy_id_for_query();
        $order->save();
        return view('backend.sales.seller_orders.show', compact('order'));
    }


    // Pickup point orders
    public function pickup_point_order_index(Request $request)
    {
        $date = $request->date;
        $sort_search = null;

        if (Auth::user()->user_type == 'staff' && Auth::user()->staff->pick_up_point != null) {
            //$orders = Order::where('pickup_point_id', Auth::user()->staff->pick_up_point->id)->get();
            $orders = DB::table('orders')
                ->orderBy('code', 'desc')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->where('order_details.pickup_point_id', Auth::user()->staff->pick_up_point->id)
                ->select('orders.id')
                ->distinct();

            if ($request->has('search')) {
                $sort_search = $request->search;
                $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
            }
            if ($date != null) {
                $orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }

            $orders = $orders->paginate(15);

            return view('backend.sales.pickup_point_orders.index', compact('orders', 'sort_search', 'date'));
        } else {
            //$orders = Order::where('shipping_type', 'Pick-up Point')->get();
            $orders = DB::table('orders')
                ->orderBy('code', 'desc')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->where('order_details.shipping_type', 'pickup_point')
                ->select('orders.id')
                ->distinct();

            if ($request->has('search')) {
                $sort_search = $request->search;
                $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
            }
            if ($date != null) {
                $orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }

            $orders = $orders->paginate(15);

            return view('backend.sales.pickup_point_orders.index', compact('orders', 'sort_search', 'date'));
        }
    }

    public function pickup_point_order_sales_show($id)
    {
        if (Auth::user()->user_type == 'staff') {
            $order = Order::where('id', decrypt($id))->first();
            return view('backend.sales.pickup_point_orders.show', compact('order'));
        } else {
            $order = Order::where('id', decrypt($id))->first();
            return view('backend.sales.pickup_point_orders.show', compact('order'));
        }
    }

    /**
     * Display a single sale to admin.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order;
        if (Auth::check()) {
            $order->user_id = Auth::user()->id;
        } else {
            $order->guest_id = mt_rand(100000, 999999);
        }

        $carts = Cart::where('user_id', Auth::user()->id)
            ->where('owner_id', $request->owner_id)
            ->get();

        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
        $shipping_info->name = Auth::user()->name;
        $shipping_info->email = Auth::user()->email;
        $order->seller_id = $request->owner_id;
        $order->shipping_address = json_encode($shipping_info);

        $order->payment_type = $request->payment_option;
        $order->delivery_viewed = '0';
        $order->payment_status_viewed = '0';
        $order->code = date('Ymd-His') . rand(10, 99);
        $order->date = strtotime('now');
        $order->tenacy_id = get_tenacy_id_for_query();
        if ($order->save()) {
            $subtotal = 0;
            $tax = 0;
            $shipping = 0;

            //calculate shipping is to get shipping costs of different types
            $admin_products = array();
            $seller_products = array();

            //Order Details Storing
            foreach ($carts as $key => $cartItem) {
                $product = Product::where('id', $cartItem['product_id'])->first();

                if ($product->added_by == 'admin') {
                    array_push($admin_products, $cartItem['product_id']);
                } else {
                    $product_ids = array();
                    if (array_key_exists($product->user_id, $seller_products)) {
                        $product_ids = $seller_products[$product->user_id];
                    }
                    array_push($product_ids, $cartItem['product_id']);
                    $seller_products[$product->user_id] = $product_ids;
                }

                $subtotal += $cartItem['price'] * $cartItem['quantity'];
                $tax += $cartItem['tax'] * $cartItem['quantity'];

                $product_variation = $cartItem['variation'];

                $product_stock = $product->stocks->where('variant', $product_variation)->first();
                if ($product->digital != 1 && $cartItem['quantity'] > $product_stock->qty) {
                    flash(translate('The requested quantity is not available for ') . $product->getTranslation('name'))->warning();
                    $order->delete();
                    return redirect()->route('cart')->send();
                } elseif ($product->digital != 1) {
                    $product_stock->qty -= $cartItem['quantity'];
                    $product_stock->tenacy_id = get_tenacy_id_for_query();
                    $product_stock->save();
                }

                $order_detail = new OrderDetail;
                $order_detail->order_id = $order->id;
                $order_detail->seller_id = $product->user_id;
                $order_detail->product_id = $product->id;
                $order_detail->variation = $product_variation;
                $order_detail->price = $cartItem['price'] * $cartItem['quantity'];
                $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                $order_detail->shipping_type = $cartItem['shipping_type'];
                $order_detail->product_referral_code = $cartItem['product_referral_code'];
                $order_detail->shipping_cost = $cartItem['shipping_cost'];

                $shipping += $order_detail->shipping_cost;

                if ($cartItem['shipping_type'] == 'pickup_point') {
                    $order_detail->pickup_point_id = $cartItem['pickup_point'];
                }
                //End of storing shipping cost

                $order_detail->quantity = $cartItem['quantity'];
                $order_detail->tenacy_id = get_tenacy_id_for_query();
                $order_detail->save();

                $product->num_of_sale++;
                $product->tenacy_id = get_tenacy_id_for_query();
                $product->tenacy_id = get_tenacy_id_for_query();
                $product->save();

                if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null &&
                    \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {
                    if ($order_detail->product_referral_code) {
                        $referred_by_user = User::where('referral_code', $order_detail->product_referral_code)->first();

                        $affiliateController = new AffiliateController;
                        $affiliateController->processAffiliateStats($referred_by_user->id, 0, $order_detail->quantity, 0, 0);
                    }
                }
            }

            $order->grand_total = $subtotal + $tax + $shipping;

            if ($carts->first()->coupon_code != '') {
                $order->grand_total -= $carts->sum('discount');
                if (Session::has('club_point')) {
                    $order->club_point = Session::get('club_point');
                }
                $order->coupon_discount = $carts->sum('discount');

//                $clubpointController = new ClubPointController;
//                $clubpointController->deductClubPoints($order->user_id, Session::get('club_point'));

                $coupon_usage = new CouponUsage;
                $coupon_usage->user_id = Auth::user()->id;
                $coupon_usage->coupon_id = Coupon::where('code', $carts->first()->coupon_code)->first()->id;
                $coupon_usage->save();
            }

            $order->tenacy_id = get_tenacy_id_for_query();
            $order->save();

            $array['view'] = 'emails.invoice';
            $array['subject'] = translate('Your order has been placed') . ' - ' . $order->code;
            $array['from'] = env('MAIL_FROM_ADDRESS');
            $array['order'] = $order;

            foreach ($seller_products as $key => $seller_product) {
                try {
                    Mail::to(\App\User::find($key)->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {

                }
            }

            if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_order')->first()->value) {
                try {
                    $otpController = new OTPVerificationController;
                    $otpController->send_order_code($order);
                } catch (\Exception $e) {

                }
            }

            //sends email to customer with the invoice pdf attached
            if (env('MAIL_USERNAME') != null) {
                try {
                    Mail::to(Auth::user()->email)->queue(new InvoiceEmailManager($array));
                    Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {

                }
            }

            $request->session()->put('order_id', $order->id);
        }

        return $order;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::where('id', $id)->first();
        if ($order != null) {
            foreach ($order->orderDetails as $key => $orderDetail) {
                try {

                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)->where('variant', $orderDetail->variation)->first();
                    if ($product_stock != null) {
                        $product_stock->qty += $orderDetail->quantity;
                        $product_stock->tenacy_id = get_tenacy_id_for_query();
                        $product_stock->save();
                    }

                } catch (\Exception $e) {

                }

                $orderDetail->delete();
            }
            $order->delete();
            flash(translate('Order has been deleted successfully'))->success();
        } else {
            flash(translate('Something went wrong'))->error();
        }
        return back();
    }

    public function bulk_order_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $order_id) {
                $this->destroy($order_id);
            }
        }

        return 1;
    }

    public function order_details(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();
        $order->tenacy_id = get_tenacy_id_for_query();
        $order->save();
        return view('frontend.user.seller.order_details_seller', compact('order'));
    }

    public function update_delivery_status(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();
        $response = 1;
        $shipping_address = json_decode($order->shipping_address);
        if (!empty($shipping_address->delivery_tenancy_id)) {
            $order->shipping_address = $this->repOrder->convertDataToDeliveryPartner($order, $shipping_address);
        }

        $order->delivery_viewed = '0';
        $order->delivery_status = $request->status;
        $order->tenacy_id = get_tenacy_id_for_query();
        $order->save();

        if (Auth::user()->user_type == 'seller') {
            foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail) {
                $orderDetail->delivery_status = $request->status;
                $orderDetail->tenacy_id = get_tenacy_id_for_query();
                $orderDetail->save();

                if ($request->status == 'cancelled') {
                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)
                        ->where('variant', $orderDetail->variation)
                        ->first();
                    if ($product_stock != null) {
                        $product_stock->qty += $orderDetail->quantity;
                        $product_stock->tenacy_id = get_tenacy_id_for_query();
                        $product_stock->save();
                    }
                }
            }
        } else {
            foreach ($order->orderDetails as $key => $orderDetail) {

                $orderDetail->delivery_status = $request->status;
                $orderDetail->tenacy_id = get_tenacy_id_for_query();
                $orderDetail->save();

                if ($request->status == 'cancelled') {
//
                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)
                        ->where('variant', $orderDetail->variation)
                        ->first();

                    if ($product_stock != null) {
                        $product_stock->qty += $orderDetail->quantity;
                        $product_stock->tenacy_id = get_tenacy_id_for_query();
                        $product_stock->save();
                    }
                }

                if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {
                    if (($request->status == 'delivered' || $request->status == 'cancelled') &&
                        $orderDetail->product_referral_code) {

                        $no_of_delivered = 0;
                        $no_of_canceled = 0;

                        if ($request->status == 'delivered') {
                            $no_of_delivered = $orderDetail->quantity;
                        }
                        if ($request->status == 'cancelled') {
                            $no_of_canceled = $orderDetail->quantity;
                        }

                        $referred_by_user = User::where('referral_code', $orderDetail->product_referral_code)->first();

                        $affiliateController = new AffiliateController;
                        $affiliateController->processAffiliateStats($referred_by_user->id, 0, 0, $no_of_delivered, $no_of_canceled);
                    }
                }
            }
        }

        if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_delivery_status')->first()->value) {
            try {
                $otpController = new OTPVerificationController;
                $otpController->send_delivery_status($order);
            } catch (\Exception $e) {
            }
        }

        if (\App\Addon::where('unique_identifier', 'delivery_boy')->first() != null &&
            \App\Addon::where('unique_identifier', 'delivery_boy')->first()->activated) {

            if (Auth::user()->user_type == 'delivery_boy') {
                $deliveryBoyController = new DeliveryBoyController;
                $deliveryBoyController->store_delivery_history($order);
            }
        }

        return $response;
    }

//    public function bulk_order_status(Request $request) {
////        dd($request->all());
//        if($request->id) {
//            foreach ($request->id as $order_id) {
//                $order = Order::findOrFail($order_id);
//                $order->delivery_viewed = '0';
//                $order->tenacy_id = get_tenacy_id_for_query(); $order->save();
//
//                $this->change_status($order, $request);
//            }
//        }
//
//        return 1;
//    }

    public function update_payment_status(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();
        $order->payment_status_viewed = '0';
        $order->tenacy_id = get_tenacy_id_for_query();
        $order->save();

        if (Auth::user()->user_type == 'seller') {
            foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail) {
                $orderDetail->payment_status = $request->status;
                $orderDetail->tenacy_id = get_tenacy_id_for_query();
                $orderDetail->save();
            }
        } else {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->payment_status = $request->status;
                $orderDetail->tenacy_id = get_tenacy_id_for_query();
                $orderDetail->save();
            }
        }

        $status = 'paid';
        foreach ($order->orderDetails as $key => $orderDetail) {
            if ($orderDetail->payment_status != 'paid') {
                $status = 'unpaid';
            }
        }
        $order->payment_status = $status;
        $order->tenacy_id = get_tenacy_id_for_query();
        $order->save();


        if ($order->payment_status == 'paid' && $order->commission_calculated == 0) {
            commission_calculation($order);

            $order->commission_calculated = 1;
            $order->tenacy_id = get_tenacy_id_for_query();
            $order->save();
        }

        if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value) {
            try {
                $otpController = new OTPVerificationController;
                $otpController->send_payment_status($order);
            } catch (\Exception $e) {
            }
        }
        return 1;
    }

    public function assign_delivery_boy(Request $request)
    {
        if (\App\Addon::where('unique_identifier', 'delivery_boy')->first() != null &&
            \App\Addon::where('unique_identifier', 'delivery_boy')->first()->activated) {

            $order = Order::where('id', $request->order_id)->first();
            $order->assign_delivery_boy = $request->delivery_boy;
            $order->delivery_history_date = date("Y-m-d H:i:s");
            $order->tenacy_id = get_tenacy_id_for_query();
            $order->save();

            $delivery_history = \App\DeliveryHistory::where('order_id', $order->id)
                ->where('delivery_status', $order->delivery_status)
                ->first();

            if (empty($delivery_history)) {
                $delivery_history = new \App\DeliveryHistory;

                $delivery_history->order_id = $order->id;
                $delivery_history->delivery_status = $order->delivery_status;
                $delivery_history->payment_type = $order->payment_type;
            }
            $delivery_history->delivery_boy_id = $request->delivery_boy;

            $delivery_history->save();

            if (env('MAIL_USERNAME') != null && get_setting('delivery_boy_mail_notification') == '1') {
                $array['view'] = 'emails.invoice';
                $array['subject'] = translate('You are assigned to delivery an order. Order code') . ' - ' . $order->code;
                $array['from'] = env('MAIL_FROM_ADDRESS');
                $array['order'] = $order;

                try {
                    Mail::to($order->delivery_boy->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {

                }
            }

            if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null &&
                \App\Addon::where('unique_identifier', 'otp_system')->first()->activated &&
                get_setting('delivery_boy_otp_notification') == '1') {
                try {
                    SmsUtility::assign_delivery_boy($order->delivery_boy->phone, $order->code);
                } catch (\Exception $e) {

                }
            }
        }

        return 1;
    }
}
