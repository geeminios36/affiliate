<?php

namespace App\Http\Requests;

use App\DeliveryPartners;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Console\Input\Input;

class PosOrderDeliveryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
         $validate = [
            'to_phone' => 'required|digits:10|numeric',
            'to_name' => 'required',
            'service_type_id' => 'required',
            'to_address' => 'required',
            'to_district_id' => 'required',
            'to_ward_code' => 'required',
            'payment_type_id' => 'required',
            'insurance_value' => 'regex:/^[0-9\.,]+$/',
            'cod_amount' => 'regex:/^[0-9\.,]+$/',
        ];

        $deliveryPartnerModel = new DeliveryPartners();
        $delivery_partner_id = $this->input('delivery_partner_id');
        $delivery_partner = $deliveryPartnerModel->find($delivery_partner_id);
        if (empty($delivery_partner)){
            return response_json(false, 'Không tồn tại đơn vị giao hàng này');
        }

        if ($delivery_partner->code == config('constants.ghtk')) {
            $validate = array_merge($validate, ['to_province' => 'required']);
        } elseif ($delivery_partner->code == config('constants.ghn')) {
            $validate = array_merge($validate, [
                'required_note' => 'required',
                'length' => 'numeric',
                'width' => 'numeric',
                'height' => 'numeric',
                'weight' => 'numeric',
            ]);
        }

        return $validate;
    }
}
