<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\BusinessSetting;
use App\Currency;

class SettingsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'name' => $data->name,
                    'logo' => $data->logo,
                    'facebook' => $data->facebook,
                    'twitter' => $data->twitter,
                    'instagram' => $data->instagram,
                    'youtube' => $data->youtube,
                    'google_plus' => $data->google_plus,
                    'currency' => [
                        'name' => Currency::where('id', BusinessSetting::where('type', 'system_default_currency')->first()->value)->first()->name,
                        'symbol' => Currency::where('id', BusinessSetting::where('type', 'system_default_currency')->first()->value)->first()->symbol,
                        'exchange_rate' => (double) $this->exchangeRate(Currency::where('id', BusinessSetting::where('type', 'system_default_currency')->first()->value)->first()),
                        'code' => Currency::where('id', BusinessSetting::where('type', 'system_default_currency')->first()->value)->first()->code
                    ],
                    'currency_format' => $data->currency_format
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }

    public function exchangeRate($currency){
        $base_currency = Currency::where('id',BusinessSetting::where('type', 'system_default_currency')->first()->value)->first();
        return $currency->exchange_rate/$base_currency->exchange_rate;
    }
}
