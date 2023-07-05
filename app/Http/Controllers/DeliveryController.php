<?php

namespace App\Http\Controllers;

use App\DeliveryPartners;
use App\DeliveryTenancies;
use App\Http\Traits\DeliveryTenancyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    //
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    use DeliveryTenancyTrait;

    public function index()
    {
        $deliveryPartners = $this->getDeliveryPartners();
        $deliveryPartnerCode = $deliveryPartners->pluck('code')->toJson();
        return view('backend.delivery.partner.index', compact('deliveryPartners', 'deliveryPartnerCode'));
    }

    public function reload()
    {
        $deliveryPartners = $this->getDeliveryPartners();
        return view('backend.delivery.partner.delivery_partners', compact('deliveryPartners'))->render();
    }

    private function getDeliveryPartners()
    {
        return DeliveryPartners::whereIn('code', ['dhl', 'ghn'])->with('delivery_tenancy')->get();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveConnectGHN(Request $request)
    {
        $inputData = $request->all();
        if (empty($inputData['ghn_id'])) {
            return response()->json([
                'status' => false,
                'msg' => 'Vui lòng chọn liên kết'
            ]);
        }

        $address = explode('-', $inputData['address']);
        if (empty($address[1])) {
            return response()->json([
                'status' => false,
                'msg' => 'Vui lòng tạo địa chỉ giao hàng'
            ]);
        }
        if (!empty($inputData['connect_partner_id'])) {
            DeliveryTenancies::where('connect_partner_id', $inputData['connect_partner_id'])
                ->update(['connect_partner_id' => (int)$inputData['ghn_id']]);
        } else {
            if (empty($inputData['delivery_id'])) {
                return response()->json([
                    'status' => false,
                    'msg' => 'Không tồn tại đơn vị vận chuyển này'
                ]);
            }

            $data = [
                'delivery_partner_id' => (int)$inputData['delivery_id'],
                'connect_partner_id' => $inputData['ghn_id'],
                'status' => 1,
                'updated_by' => Auth::user()->id,
                'token_key' => $inputData['token_key']
            ];
            DeliveryTenancies::create($data);
        }


        return response()->json([
            'status' => true,
            'msg' => 'Kết nối đối tác vận chuyển thành công'
        ]);
    }

    public function logOutDelivery($delivery_tenancy_id)
    {

        $delivery_tenancy = $this->validateDeliveryTenancy($delivery_tenancy_id);

        DeliveryTenancies::whereId($delivery_tenancy->id)->update(['status' => 0]);

        return response()->json([
            'status' => false,
            'msg' => 'Ngừng kết nối đơn vị vận chuyển thành công'
        ]);
    }

    public function updateDelivery($delivery_tenancy_id)
    {
        $deliveryTenancy = DeliveryTenancies::whereId($delivery_tenancy_id)
            ->withAndWhereHas('delivery_partners', function () {

            })
            ->first();

        return view('backend.delivery.partner.modal.info_modal', compact('deliveryTenancy'))->render();
    }

    private function validateDeliveryTenancy($delivery_tenancy_id)
    {
        if (empty($delivery_tenancy_id)) {
            return response()->json([
                'status' => false,
                'msg' => 'Không tồn tại đơn vị vận chuyển này'
            ]);
        }

        $delivery_tenancy = DeliveryTenancies::find($delivery_tenancy_id);
        if (empty($delivery_tenancy)) {
            return response()->json([
                'status' => false,
                'msg' => 'Không tồn tại đơn vị vận chuyển này'
            ]);
        }
        return $delivery_tenancy;
    }

    public function loginGHTK(Request $request)
    {
//        $token = 'F0151Fb4e7e938a0ea67B09235B728b57Ad22bd8';
        $config = config('api_delivery_partner.' . config('constants.ghtk') . '.shop');
        $method = 'GET';
        $response = DeliveryTenancyTrait::curlApi($request->token, $config, $method);
        if (empty($response)){
            return response_json(false, 'Vui lòng kiểm tra lại đường truyển mạng');
        }elseif ($response != strip_tags($response)){
            return response_json(false, 'Token không tồn tại');
        }
        echo $response;
    }

    public function saveConnectGHTK(Request $request)
    {
        $inputData = $request->all();
        if (empty($inputData['ghtk_id'])) {
            return response()->json([
                'status' => false,
                'msg' => 'Vui lòng chọn liên kết'
            ]);
        }

        $address = explode('-', $inputData['address']);
        if (empty($address[1])) {
            return response()->json([
                'status' => false,
                'msg' => 'Vui lòng tạo địa chỉ giao hàng'
            ]);
        }
        if (!empty($inputData['connect_partner_id'])) {
            DeliveryTenancies::where('connect_partner_id', $inputData['connect_partner_id'])
                ->update(['connect_partner_id' => (int)$inputData['ghtk_id']]);
        } else {
            if (empty($inputData['delivery_id'])) {
                return response()->json([
                    'status' => false,
                    'msg' => 'Không tồn tại đơn vị vận chuyển này'
                ]);
            }

            $data = [
                'delivery_partner_id' => (int)$inputData['delivery_id'],
                'connect_partner_id' => $inputData['ghtk_id'],
                'status' => 1,
                'updated_by' => Auth::user()->id,
                'token_key' => $inputData['token_key']
            ];
            DeliveryTenancies::create($data);
        }


        return response()->json([
            'status' => true,
            'msg' => 'Kết nối đối tác vận chuyển thành công'
        ]);
    }

    public function loginViettelPost(Request $req)
    {
        $url = 'https://partner.viettelpost.vn/v2/user/Login';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_POST, 1);

        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($req->all()));

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        echo $result;
    }

    public function loginBestExpress(Request $request)
    {
        $inputData = $request->all();
        $inputData['password'] = md5($inputData['password']);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => config('api_delivery_partner.' . config('constants.bestexpress') . '.shop'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $inputData,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        dd(json_decode($response));
        echo $response;
    }
}
