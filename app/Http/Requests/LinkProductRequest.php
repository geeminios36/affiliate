<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkProductRequest extends FormRequest
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
        return [
            'product_sku' => 'required',
            'variant_sku' => 'required',
            'market_id' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'product_sku.required' => 'Không tồn tại mã sku của sản phẩm cha',
            'variant_sku.required' => 'Không tồn tại mã sku của sản phẩm variant',
            'market_id.required' => 'Không tồn tại liên kết',
            'market_id.numeric' => 'Không tồn tại liên kết',
        ];
    }
}
