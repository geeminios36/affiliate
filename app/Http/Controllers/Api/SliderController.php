<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SliderCollection;

class SliderController extends Controller
{
    public function index()
    {
        $slider_images = json_decode(get_setting('home_slider_images'), true);

        $data = [
            'data' => [],
            'success' => true,
            'status' => 200
        ];
        foreach ($slider_images as $key => $value) {
            $data['data'][] = [
                'photo' => uploaded_asset($slider_images[$key]),
                'url' => json_decode(get_setting('home_slider_links'), true)[$key]
            ];
        }

        return $data;
        
        // return new SliderCollection(json_decode(get_setting('home_slider_images'), true));
    }
}
