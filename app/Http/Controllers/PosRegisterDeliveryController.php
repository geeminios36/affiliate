<?php

namespace App\Http\Controllers;

use App\Http\Traits\DeliveryTenancyTrait;
use App\Locations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use function GuzzleHttp\json_decode;

class PosRegisterDeliveryController extends Controller
{
    //
    use DeliveryTenancyTrait;

    /**
     * @var Locations
     */
    private $locations;

    public function __construct()
    {
        $this->locations = new Locations();
    }

    public function getFormRegisterDelivery($deliveryTenancyId)
    {
        $deliveryTenancy = DeliveryTenancyTrait::getDeliveryTenancyById($deliveryTenancyId);
        if (empty($deliveryTenancy)) {
            return response()->json([
                'status' => false,
                'msg' => 'Vui lòng kết nối đơn vị vận chuyển'
            ]);
        }

        $code = $deliveryTenancy->delivery_partners->code;
        $logo = $deliveryTenancy->delivery_partners->logo;

        $config = config('api_delivery_partner.' . $code . '.shop');
        $response = DeliveryTenancyTrait::cURLApi($deliveryTenancy->token_key, $config);
        $shop = json_decode($response);
        $location = [];
        $provinces = [];
        if (!empty($shop)) {
            if ($code == config('constants.ghn')) {
                $shop = collect(json_decode($response)->data->shops)
                    ->where('_id', $deliveryTenancy->connect_partner_id)
                    ->first();
                $ghnInfo = $this->getInfoGHNShop($shop, $code, $deliveryTenancy);
                $shop = $ghnInfo['shop'];
                $location = $ghnInfo['location'];
            } elseif ($code == config('constants.ghtk')) {
                $shop = collect(json_decode($response)->data)
                    ->where('pick_address_id', $deliveryTenancy->connect_partner_id)
                    ->first();
            }
        }

        return response()->json([
            'view' => view('pos.modal_register_delivery.modal_' . $code, compact('shop', 'location', 'logo'))->render(),
            'delivery_tenancy' => $deliveryTenancy->toArray(),
            'code' => $code,
        ]);
    }

    private function getInfoGHNShop($shop, $code, $deliveryTenancy)
    {
        $district_id = $shop->district_id;
        $pick_shift = $this->getPickShift($code, $deliveryTenancy->token_key);
        $location = $this->getDistrictWard($district_id, $code, $deliveryTenancy->token_key);

        $district = collect($location['district']->data)
            ->where('DistrictID', $district_id)
            ->first();

        $ward = collect($location['ward']->data)->where('DistrictID', $district_id)->first();

        $shop->address = $shop->address . ', ' . $district->DistrictName . ', ' . $ward->WardName;
        $shop->pick_shift = $pick_shift;

        return [
            'shop' => $shop,
            'location' => $location,
        ];
    }

    private function getDistrictWard($district_id, $code, $token_key)
    {
        $method = 'GET';
        $config_district = config('api_delivery_partner.' . $code . '.district');
        $district = DeliveryTenancyTrait::cURLApi($token_key, $config_district, $method);
        $district = json_decode($district);
        $config_ward = config('api_delivery_partner.' . $code . '.ward') . $district_id;
        $ward = DeliveryTenancyTrait::cURLApi($token_key, $config_ward, $method);
        $ward = json_decode($ward);

        return [
            'district' => $district,
            'ward' => $ward,
        ];
    }

    private function getPickShift($code, $token_key)
    {
        $method = 'GET';
        $pick_shift = config('api_delivery_partner.' . $code . '.pick_shift');
        $pick_shift = DeliveryTenancyTrait::cURLApi($token_key, $pick_shift, $method);
        $pick_shift = json_decode($pick_shift);
        return $pick_shift->data;
    }

    public function getWardByDistrictId(Request $request, $districtId)
    {
        $inputData = $request->all();
        $config_ward = config('api_delivery_partner.' . $inputData['code'] . '.ward') . $districtId;
        $ward = DeliveryTenancyTrait::cURLApi($inputData['token'], $config_ward, 'GET');

        return $ward;
    }

    public function getShippingFee(Request $request)
    {
        $inputData = $request->all();
        $preview = config('api_delivery_partner.' . $inputData['code'] . '.preview');
        $shop = DeliveryTenancyTrait::getShopInfo($inputData['delivery_tenancy_id']);

        if ($inputData['code'] == config('constants.ghtk')) {
            return $this->getShippingFeeGHTK($inputData, $shop);
        }


        $items = collect();
        foreach (Session::get('posCart') as $key => $cartItem) {
            $items->push([
                'name' => 'Chưa lưu',
                'code' => 'abc',
                'quantity' => (int)$cartItem['quantity'],
                'price' => (int)$cartItem['price'],
                "weight" => (int)$inputData["weight"],
                "length" => (int)@$inputData["length"],
                "width" => (int)@$inputData["width"],
                "height" => (int)@$inputData["height"],
            ]);
        }

        $data = [
            "payment_type_id" => (int)$inputData['payment_type_id'],
            "note" => $inputData['note'],
            "required_note" => $inputData['required_note'],
            "return_phone" => $shop->phone,
            "return_address" => $shop->address,
            "return_district_id" => $shop->district_id,
            "return_ward_code" => $shop->ward_code,
            "client_order_code" => '',
            "to_name" => $inputData["to_name"],
            "to_phone" => $inputData["to_phone"],
            "to_address" => $inputData["to_address"],
            "to_ward_code" => $inputData["to_ward_code"],
            "cod_amount" => (int)$inputData["cod_amount"],
            "content" => $inputData["content"],
            "weight" => (int)$inputData["weight"],
            "length" => (int)$inputData["length"],
            "width" => (int)$inputData["width"],
            "height" => (int)$inputData["height"],
            "pick_station_id" => 0,
            "insurance_value" => (int)un_number_format($inputData["insurance_value"]),
            "service_id" => 0,
            "service_type_id" => (int)$inputData["service_type_id"],
            "coupon" => null,
            'items' => $items->toArray(),
        ];

        $preview = DeliveryTenancyTrait::cURLApi($inputData['token'], $preview, 'GET', $data, (int)$inputData['shopId']);

        return $preview;
    }

    public function getShippingFeeGHTK($inputData, $shop)
    {
        $token = $inputData['token'];
        $addressArr = $shop->address;

        $to_district = $this->locations->find($inputData['to_district_id']);
        $to_province = $this->locations->find($inputData['to_province']);
        $to_ward_code =$this->locations->find($inputData['to_ward_code']);

        $dataXFAST = [
            "customer_district" => $to_district->fullname,
            "customer_province" => $to_province->fullname,
            "customer_ward" => $to_ward_code->fullname,
            "customer_first_address" => $inputData['to_address'],
            "pick_province" => $addressArr[3],
            "pick_district" => $addressArr[2],
            "pick_ward" => $addressArr[1]
        ];

        $configXfastCheck = config('api_delivery_partner.ghtk.xfast_check') . http_build_query($dataXFAST);
        $checkXFast = DeliveryTenancyTrait::cURLApi($token, $configXfastCheck, 'GET');
        $checkXFast = json_decode($checkXFast);

        $tags = empty($inputData['tag_ghtk']) ? [] : explode(',', $inputData['tag_ghtk']);
        $checkTags = [];

        if (count($tags) && in_array('is_breakable', $tags)) {
            array_push($checkTags, config('constants.is_breakable'));
        }
        if (count($tags) && in_array('is_food', $tags)) {
            array_push($checkTags, config('constants.is_food'));
        }

        $data = [
            "pick_province" => $addressArr[3],
            "pick_district" => $addressArr[2],
            "province" => $to_province->fullname,
            "district" => $to_district->fullname,
            "address" => $inputData['to_address'],
            "weight" => count($inputData['weight']) == 0 ? 0 : array_sum($inputData['weight'])*config('constants.kg_to_gram'),
            "value" => $inputData['price_products'],
            "transport" => $inputData['service_type_id'],
            "deliver_option" => (isset($checkXFast->success) && $checkXFast->success) ? 'xtream' : 'none',
            "tags" => $checkTags,
        ];

        $configDeliveryFee = config('api_delivery_partner.ghtk.delivery_fee') . http_build_query($data);

        $checkDeliveryFee = DeliveryTenancyTrait::cURLApi($token, $configDeliveryFee, 'GET');
        $checkDeliveryFee = json_decode($checkDeliveryFee);

        $collectDeliveryFee = collect([
            'code' => $checkDeliveryFee->success ? 200 : false,
            'message' => $checkDeliveryFee->message,
            'data' => [
                'total_fee' => $checkDeliveryFee->fee->fee,
            ]
        ]);

        return $collectDeliveryFee->toJson();
    }

    public function getLocations(Request $request)
    {
        $data_input = $request->all();

        $data_query = Locations::where('parent_id', $data_input['parent_id']);

        if (!empty($data_input['keyword'])) {
            $data_query = $data_query->WhereRaw('fullname like "%' . $data_input['keyword'] . '%"');
        }

        $data_query = $data_query->paginate(30);

        $data['total'] = $data_query->total();

        $provinces = [];
        foreach ($data_query as $provinceInfo) {
            $province_info = [];
            $province_info['id'] = $provinceInfo->id;
            $province_info['fullname'] = $provinceInfo->fullname;
            $provinces[] = $province_info;
        }

        $data['object'] = $provinces;

        return json_encode($data);
    }
}
