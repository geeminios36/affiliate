<?php

namespace App\Http\Repository;

use App\BusinessSetting;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BusinessSettingRepository
{
    public function __construct()
    {
        $this->model = new BusinessSetting();
    }

    public function getCheckoutAppotaPay($order, $inputData, $ip)
    {
        $business_settings = BusinessSetting::where('type', 'appotapay_sandbox')->first();
        $appotaPayUrl = !empty($business_settings->value) ? config('payment.appotapay.sandbox') : config('payment.appotapay.prod');
        $appotaPayHashSecret = env('APPOTAPAY_SECRET_KEY');
        $object = [
            'action' => 'PAY',
            'amount' => $order->grand_total,
            'bankCode' => $inputData['bankCode'],
            'clientIp' => $ip,
            'extraData' => '',
            'notifyUrl' => route('checkout.appota'),
            'orderId' => (string)$order->id,
            'orderInfo' => $inputData['OrderDescription'],
            'paymentMethod' => $inputData['paymentMethod'],
            'redirectUrl' => route('checkout.appota'),
        ];

        $i = 0;
        $hashdata = "";
        foreach ($object as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . $value;
            } else {
                $hashdata .= urlencode($key) . "=" . $value;
                $i = 1;
            }
        }

        $signature = hash_hmac('sha256', $hashdata, $appotaPayHashSecret);

        $object = array_merge($object, ['signature' => $signature]);

        $payload = [
            "iss" => env('APPOTAPAY_PARTNER_CODE'),
            "jti" => env('APPOTAPAY_API_KEY') . "-" . strtotime(Carbon::now()), // (ex time: 1614225624)
            "api_key" => env('APPOTAPAY_API_KEY'),
            "exp" => strtotime(Carbon::now()),
        ];


        $jwt = JWT::encode($payload, $appotaPayHashSecret, 'HS256', null, ["cty" => "appotapay-api;v=1"]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $appotaPayUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($object),
            CURLOPT_HTTPHEADER => array(
                'X-APPOTAPAY-AUTH: Bearer '.$jwt,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response);
        if (!empty($response->errorCode)){
            return response_json(false, 'Có lỗi xảy ra');
        }

        return Redirect::to($response->paymentUrl);

    }

    public function getCheckoutVnpay($order, $inputData)
    {
        $business_settings = BusinessSetting::where('type', 'vnpay_sandbox')->first();
        $vnp_Url = !empty($business_settings->value) ? config('payment.vnpay.sandbox') : config('payment.vnpay.prod');

        $vnp_Returnurl = route('checkout.vnpay');
        $vnp_TmnCode = env('VNPAY_TERMINAL_ID');//Mã website tại VNPAY
        $vnp_HashSecret = env('VNPAY_SECRET_KEY'); //Chuỗi bí mật

        $vnp_TxnRef = $order['code']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = stripVN($inputData['OrderDescription']);;
        $vnp_Amount = $order['grand_total'] * 100;;
        $vnp_BankCode = $inputData['bankcode'];
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => 'vn',
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return Redirect::to($vnp_Url);
    }

    public function getCheckoutMomo($order)
    {
        $business_settings = BusinessSetting::where('type', 'momo_sandbox')->first();
        $endpoint = !empty($business_settings->value) ? config('payment.momo.sandbox') : config('payment.vnpay.prod');

        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey = env('ACCESS_KEY');
        $secretKey = env('MOMO_SECRET_KEY');
        $orderInfo = "Thanh toán đơn hàng mã " . $order->code;
        $amount = $order->grand_total;
        $orderId = time() . "";
        $redirectUrl = route('checkout.momo');
        $ipnUrl = route('checkout.momo'); //not work

        $requestId = time() . "";
        $requestType = "captureWallet";
        $extraData = (@$_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl="
            . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array('partnerCode' => $partnerCode,
            'partnerName' => Auth::user()->name,
            "storeId" => $order->code,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature);
        $result = $this->execPostRequest($endpoint, json_encode($data));

        $jsonResult = json_decode($result, true);  // decode json
        //Just a example, please check more in there
        return redirect($jsonResult['payUrl']);
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

}
