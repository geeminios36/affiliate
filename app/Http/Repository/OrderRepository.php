<?php

namespace App\Http\Repository;

use App\BusinessSetting;
use App\DeliveryTenancies;
use App\Http\Controllers\ClubPointController;
use App\Http\Traits\DeliveryTenancyTrait;
use App\Locations;
use App\Mail\InvoiceEmailManager;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use function GuzzleHttp\json_decode;

class OrderRepository
{
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $ghn_status_order;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $ghtk_status_order;
    /**
     * @var Order
     */
    private $model;

    public function __construct()
    {
        $this->model = new Order();
        $this->location = new Locations();
        $this->ghn_status_order = config('constants.ghn_status_order');
        $this->ghtk_status_order = config('constants.ghtk_status_order');
    }

    /**
     * @param $delivery_tenancies_id
     * @return Locations
     */
    public function getDataDelivery($deliveryTenancy, $delivery_tenancies_id, $code)
    {
        $orders = Order::select('shipping_address', 'seller_id', 'user_id', 'created_at')->get();
        $token_key = @$deliveryTenancy->token_key;

        $collectOrders = collect();
        $orders->filter(function ($value) use ($collectOrders, $delivery_tenancies_id, $code, $token_key) {
            $order_shipping_address = json_decode($value->shipping_address);
            if (isset($order_shipping_address->delivery_tenancy_id) &&
                $delivery_tenancies_id == $order_shipping_address->delivery_tenancy_id &&
                isset($order_shipping_address->is_hand_over)
            ) {
                $config = config('api_delivery_partner.' . $code . '.order_detail');
                $method = 'GET';
                $data = [];
                if ($code == config('constants.ghn')) {
                    $data = ['order_code' => $order_shipping_address->order_code];
                    $response = DeliveryTenancyTrait::curlApi($token_key, $config, $method, $data);

                    $arrayGHN = $this->getDataDeliveryGHN($order_shipping_address, $value, json_decode($response));
                    $collectOrders->push($arrayGHN);
                } elseif ($code == config('constants.ghtk')) {
                    $config = $config . $order_shipping_address->order_code->label;
                    $response = DeliveryTenancyTrait::curlApi($token_key, $config, $method, $data);

                    $arrayGHTK = $this->getDataDeliveryGHTK($order_shipping_address, $value, json_decode($response));
                    $collectOrders->push($arrayGHTK);

                }

                $response = json_decode($response);

                return $collectOrders;
            }
        });

        return $collectOrders;
    }

    /**
     * @param $order_shipping_address
     * @param $value
     * @param $response
     * @return array
     */
    public function getDataDeliveryGHN($order_shipping_address, $value, $response)
    {
        return [
            'shipping_address' => $order_shipping_address,
//            'cod_amount' => $order_shipping_address->cod_amount,
            'order_code' => $response->data->order_code,
            'order_date' => $response->data->order_date,
            'note' => $response->data->note,
            'seller' => $value->seller,
            'created_at' => $value->created_at,
            'status' => $this->ghn_status_order[$order_shipping_address->status_delivery],
        ];
    }

    public function getDataDeliveryGHTK($order_shipping_address, $value, $response)
    {
        return [
            'shipping_address' => $order_shipping_address,
//            'cod_amount' => $order_shipping_address->status_delivery == 5 ? $response->order->value : 0,
            'order_code' => $order_shipping_address->order_code->partner_id,
            'order_date' => $response->order->pick_date,
            'note' => $order_shipping_address->note,
            'seller' => $value->seller,
            'created_at' => $value->created_at,
            'status' => $this->ghtk_status_order[$order_shipping_address->status_delivery],
        ];
    }


    /**
     * @param $inputData
     * @param $session
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function createOrderDelivery($inputData, $session)
    {
        try {
            if (Session::has('posCart') && count(Session::get('posCart')) > 0) {
                $inputData['user_id'] = $inputData['user_id'] == null ? mt_rand(100000, 999999) : $inputData['user_id'];
                if (empty($inputData['district'])) {
                    $district = $this->location->find($inputData['to_district_id']);
                    $inputData['district'] = empty($district) ? '' : $district->fullname;
                }

                if (empty($inputData['ward'])) {
                    $ward = $this->location->find($inputData['to_ward_code']);
                    $inputData['ward'] = empty($ward) ? '' : $ward->fullname;
                }

                if (isset($inputData['province']) && !empty($inputData['province'])) {
                    $province = $this->location->find($inputData['to_province']);
                    $inputData['province'] = empty($province) ? '' : $province->fullname;
                }

                $order = $this->model;
                $order->shipping_address = json_encode($inputData);
                $order->user_id = $inputData['user_id'];
                $order->payment_type = $inputData['payment_type'];
                $order->delivery_viewed = '0';
                $order->payment_status_viewed = '0';
                $order->code = date('Ymd-His') . rand(10, 99);
                $order->date = strtotime('now');
                $order->payment_status = 'paid';
                $order->payment_details = $inputData['payment_type'];
                $order->tenacy_id = get_tenacy_id_for_query();

                if ($order->save()) {
                    $subtotal = 0;
                    $tax = 0;
                    $shipping = 0;
                    foreach (Session::get('posCart') as $key => $cartItem) {
                        $product = Product::where('id', $cartItem['id'])->first();

                        $subtotal += $cartItem['price'] * $cartItem['quantity'];
                        $tax += $cartItem['tax'] * $cartItem['quantity'];

                        $product_variation = $cartItem['variant'];

                        if ($product_variation != null) {
                            $product_stock = $product->stocks->where('variant', $product_variation)->first();
                            if ($cartItem['quantity'] > $product_stock->qty) {
                                $order->delete();
                                return 0;
                            } else {
                                $product_stock->qty -= $cartItem['quantity'];
                                $product_stock->tenacy_id = get_tenacy_id_for_query();
                                $product_stock->save();
                            }
                        } else {
                            if ($cartItem['quantity'] > $product->current_stock) {
                                $order->delete();
                                return response()->json([
                                    'status' => false,
                                    'msg' => 'Số lượng hàng không đủ',
                                ]);
                            } else {
                                $product->current_stock -= $cartItem['quantity'];
                                $product->tenacy_id = get_tenacy_id_for_query();
                                $product->tenacy_id = get_tenacy_id_for_query();
                                $product->save();
                            }
                        }

                        $order_detail = new OrderDetail;
                        $order_detail->order_id = $order->id;
                        $order_detail->seller_id = $product->user_id;
                        $order_detail->product_id = $product->id;
                        $order_detail->payment_status = 'paid';
                        $order_detail->variation = $product_variation;
                        $order_detail->price = $cartItem['price'] * $cartItem['quantity'];
                        $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                        $order_detail->shipping_type = null;

                        if (Session::get('shipping', 0) == 0) {
                            $order_detail->shipping_cost = 0;
                        } else {
                            if ($cartItem['shipping'] == null) {
                                $order_detail->shipping_cost = 0;
                            } else {
                                $order_detail->shipping_cost = $cartItem['shipping'];
                                $shipping += $cartItem['shipping'];
                            }
                        }

                        $order_detail->quantity = $cartItem['quantity'];
                        $order_detail->tenacy_id = get_tenacy_id_for_query();
                        $order_detail->save();

                        $product->num_of_sale++;
                        $product->tenacy_id = get_tenacy_id_for_query();
                        $product->tenacy_id = get_tenacy_id_for_query();
                        $product->save();
                    }

                    $order->grand_total = $subtotal + $tax + $shipping;

                    if (Session::has('pos_discount')) {
                        $order->grand_total -= Session::get('pos_discount');
                        $order->coupon_discount = Session::get('pos_discount');
                    }

                    $order->tenacy_id = get_tenacy_id_for_query();
                    $order->save();

                    $array['view'] = 'emails.invoice';
                    $array['subject'] = 'Your order has been placed - ' . $order->code;
                    $array['from'] = env('MAIL_USERNAME');
                    $array['order'] = $order;

                    $admin_products = array();
                    $seller_products = array();
                    foreach ($order->orderDetails as $key => $orderDetail) {
                        if ($orderDetail->product->added_by == 'admin') {
                            array_push($admin_products, $orderDetail->product->id);
                        } else {
                            $product_ids = array();
                            if (array_key_exists($orderDetail->product->user_id, $seller_products)) {
                                $product_ids = $seller_products[$orderDetail->product->user_id];
                            }
                            array_push($product_ids, $orderDetail->product->id);
                            $seller_products[$orderDetail->product->user_id] = $product_ids;
                        }
                    }

                    foreach ($seller_products as $key => $seller_product) {
                        try {
                            Mail::to(\App\User::find($key)->email)->queue(new InvoiceEmailManager($array));
                        } catch (\Exception $e) {

                        }
                    }

                    //sends email to customer with the invoice pdf attached
                    if (env('MAIL_USERNAME') != null) {
                        try {
                            Mail::to($session->get('pos_shipping_info')['email'])->queue(new InvoiceEmailManager($array));
                            Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));
                        } catch (\Exception $e) {

                        }
                    }

                    if ($inputData['user_id'] != NULL) {
                        if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated) {
                            $clubpointController = new ClubPointController;
                            $clubpointController->processClubPoints($order);
                        }
                    }

                    if (BusinessSetting::where('type', 'category_wise_commission')->first()->value != 1) {
                        $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
                        foreach ($order->orderDetails as $key => $orderDetail) {
                            $orderDetail->payment_status = 'paid';
                            $orderDetail->tenacy_id = get_tenacy_id_for_query();
                            $orderDetail->save();
                            if ($orderDetail->product->user->user_type == 'seller') {
                                $seller = $orderDetail->product->user->seller;
                                $seller->admin_to_pay = $seller->admin_to_pay - ($orderDetail->price * $commission_percentage) / 100;
                                $seller->tenacy_id = get_tenacy_id_for_query();
                                $seller->save();
                            }
                        }
                    } else {
                        foreach ($order->orderDetails as $key => $orderDetail) {
                            $orderDetail->payment_status = 'paid';
                            $orderDetail->tenacy_id = get_tenacy_id_for_query();
                            $orderDetail->save();
                            if ($orderDetail->product->user->user_type == 'seller') {
                                $commission_percentage = $orderDetail->product->category->commision_rate;
                                $seller = $orderDetail->product->user->seller;
                                $seller->admin_to_pay = $seller->admin_to_pay - ($orderDetail->price * $commission_percentage) / 100;
                                $seller->tenacy_id = get_tenacy_id_for_query();
                                $seller->save();
                            }
                        }
                    }

                    $order->commission_calculated = 1;
                    $order->tenacy_id = get_tenacy_id_for_query();
                    $order->save();

                    $session->put('order_id', $order->id);

                    Session::forget('pos_shipping_info');
                    Session::forget('shipping');
                    Session::forget('pos_discount');
                    Session::forget('posCart');
                    return 1;
                } else {
                    return response()->json([
                        'status' => false,
                        'msg' => 'Có lỗi xảy ra!',
                    ]);
                }
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'msg' => 'Có lỗi xảy ra',
            ]);
        }

        return response()->json([
            'status' => false,
            'msg' => 'Có lỗi xảy ra',
        ]);
    }

    /**
     * @param $order
     * @param $shipping_address
     * @return string
     */
    public function convertDataToDeliveryPartner($order, $shipping_address)
    {
        $delivery_tenancy = DeliveryTenancies::find($shipping_address->delivery_tenancy_id);
        $shop = DeliveryTenancyTrait::getShopInfo($shipping_address->delivery_tenancy_id);
        $codePartner = $delivery_tenancy->delivery_partners->code;

        $weight = $shipping_address->weight;
        $items = [];
        foreach ($order->orderDetails as $key => $query) {
            if ($codePartner == config('constants.ghn')) {
                $items[] = [
                    'name' => @$query->product->name,
                    'code' => substr(str_replace(' ', '', stripVN($query->product->name)), 0, 5) . '' . $key,
                    'quantity' => $query->quantity,
                    'price' => $query->price,
                    'length' => 0,
                    'width' => 0,
                    'height' => 0,
                ];
            } elseif ($codePartner == config('constants.ghtk')) {
                $product_code = (string)$query->id;
                $weightEach = (int)$weight[$key];
                $items[] = '{
                            "name": "' . @$query->product->name . '",
                            "weight": ' . $weightEach . ',
                            "quantity":' . @$query->quantity . ',
                            "product_code": "' . $product_code . '"
                        }';
            }
        };
        $config = config('api_delivery_partner.' . $codePartner . '.create_order');

        if ($codePartner == config('constants.ghn')) {
            $method = 'GET';
            $data_given = $this->dataGHN($shipping_address, $shop, $items);
            $response = DeliveryTenancyTrait::curlApi($delivery_tenancy->token_key, $config, $method, $data_given, $delivery_tenancy->connect_partner_id);
            $order_code = json_decode($response)->data->order_code;

        } elseif ($codePartner == config('constants.ghtk')) {
            $data_given = $this->dataGHTK($shipping_address, $shop, $items, $order, $delivery_tenancy->token_key);
            $response = DeliveryTenancyTrait::curlApi($delivery_tenancy->token_key, $config, '', $data_given, null, $codePartner);
            $order_code = json_decode($response)->order;
        }

        return collect($shipping_address)->merge(collect(['is_hand_over' => true, 'order_code' => $order_code]))->toJson();
    }

    /**
     * @param $shipping_address
     * @param $shop
     * @param $items
     * @return array
     */
    private function dataGHN($shipping_address, $shop, $items)
    {
        $data_given = [
            'payment_type_id' => @(int)$shipping_address->payment_type_id,
            'note' => @$shipping_address->note,
            'required_note' => @$shipping_address->required_note,
            "return_phone" => @$shop->phone,
            "return_address" => @$shop->address,
            "return_district_id" => @$shop->district_id,
            "return_ward_code" => @$shop->ward_code,
            'to_name' => @$shipping_address->to_name,
            'to_phone' => @$shipping_address->to_phone,
            'to_address' => @$shipping_address->to_address,
            'to_ward_code' => @$shipping_address->to_ward_code,
            'cod_amount' => (int)un_number_format(@$shipping_address->cod_amount),
            'weight' => (int)@$shipping_address->weight,
            'length' => (int)@$shipping_address->length,
            'width' => (int)@$shipping_address->width,
            'height' => (int)@$shipping_address->height,
            'content' => @$shipping_address->content,
            'service_type_id' => (int)@$shipping_address->service_type_id,
            'insurance_value' => (int)un_number_format(@$shipping_address->insurance_value) - (int)@$shipping_address->discount,
            'pick_shift' => [(int)@$shipping_address->pick_shift],
            'items' => $items,
        ];

        return $data_given;
    }

    /**
     * @param $shipping_address
     * @param $shop
     * @param $items
     * @param $order
     * @param $token
     * @return string
     */
    private function dataGHTK($shipping_address, $shop, $items, $order, $token)
    {
        $dataXFAST = [
            "customer_district" => $shipping_address->district,
            "customer_province" => $shipping_address->province,
            "customer_ward" => $shipping_address->ward,
            "customer_first_address" => $shipping_address->to_address,
            "pick_province" => $shop->address[3],
            "pick_district" => $shop->address[2],
            "pick_ward" => $shop->address[1]
        ];

        $configXfastCheck = config('api_delivery_partner.ghtk.xfast_check') . http_build_query($dataXFAST);
        $checkXFast = DeliveryTenancyTrait::cURLApi($token, $configXfastCheck, 'GET');
        $checkXFast = json_decode($checkXFast);

        $tags = $shipping_address->tag_ghtk;
        $checkTags = [];

        if (count($tags) && in_array('is_breakable', $tags)) {
            array_push($checkTags, config('constants.is_breakable'));
        }
        if (count($tags) && in_array('is_food', $tags)) {
            array_push($checkTags, config('constants.is_food'));
        }

        $checkTags = '[' . implode(', ', $checkTags) . ']';
        $id = $order->id.'-'.generateRandomString(5);
        $is_freeship = $shipping_address->payment_type_id == config('constants.is_freeship') ? 1 : 0;
        $deliver_option = (isset($checkXFast->success) && $checkXFast->success) ? 'xtream' : 'none';
        $pick_session = (isset($checkXFast->success) && $checkXFast->success) ? (string)collect($checkXFast->data)->keys()[0] : 0;  //2:fake data
        $pick_money = empty(@$shipping_address->cod_amount) ? 0 : @$shipping_address->cod_amount;
        $pick_address = $shop->address[0];
        $pick_province = $shop->address[3];
        $pick_district = $shop->address[2];
        $pick_ward = $shop->address[1];
        $province = $this->location->find($shipping_address->to_province)->fullname;
        $items = '[' . implode(",\n", $items) . ']';
        $orderData =
            <<<HTTP_BODY
                {
                    "products": $items,
                    "order": {
                        "id": "$id",
                        "pick_name": "$shop->pick_name",
                        "pick_address": "$pick_address",
                        "pick_province": "$pick_province",
                        "pick_district": "$pick_district",
                        "pick_ward": "$pick_ward",
                        "pick_tel": "$shop->pick_tel",
                        "tel": "$shipping_address->to_phone",
                        "name": "$shipping_address->to_name",
                        "address": "$shipping_address->to_address",
                        "province": "$province",
                        "district": "$shipping_address->district",
                        "ward": "$shipping_address->ward",
                        "hamlet": "Khác",
                        "is_freeship": "$is_freeship",
                        "pick_date": "",
                        "pick_money": $pick_money,
                        "note": "$shipping_address->note",
                        "value": $order->grand_total,
                        "transport": "$shipping_address->service_type_id",
                        "pick_option":"cod",
                        "deliver_option" : "$deliver_option",
                        "pick_session" : $pick_session,
                        "tags": $checkTags
                    }
                }
HTTP_BODY;

        return $orderData;
    }


}
