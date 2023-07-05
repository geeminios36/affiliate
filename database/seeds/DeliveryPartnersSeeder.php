<?php

use Illuminate\Database\Seeder;
use \App\DeliveryPartners;

class DeliveryPartnersSeeder extends Seeder
{
    /**
     *
     * composer dump-autoload
     * php artisan db:seed --class=DeliveryPartnersSeeder
     *
     * @return void
     */
    public function run()
    {
        DeliveryPartners::truncate()->insert([
            [
                'fullname' => 'Giao hàng nhanh',
                'code' => config('constants.ghn'),
                'logo' => 'assets/img/delivery/ghn.png',
                'info' => 'Giải pháp giao hàng, thu hộ chuyên nghiệp với hơn 130 Bưu cục trải dài khắp mọi miền của đất nước.',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'fullname' => 'Giao hàng tiết kiệm',
                'code' => 'ghtk',
                'logo' => 'assets/img/delivery/ghtk.png',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'info' => 'Giải pháp giao hàng, thu hộ chuyên nghiệp với hơn 130 Bưu cục trải dài khắp mọi miền của đất nước.',
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);

//            [
//                'fullname' => 'Viettel Post',
//                'code' => 'vt_post',
//                'logo' => 'assets/img/delivery/viettel-post.jpg',
//                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
//                'info' => 'Cung cấp dịch vụ nhận gửi, vận chuyển và phát nhanh chứng từ hàng hóa, vật phẩm bằng đường bộ.',
//                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
//            ],
//            [
//                'fullname' => 'VNPost',
//                'code' => 'vn_post',
//                'logo' => 'assets/img/delivery/vnpt-post.jpg',
//                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
//                'info' => 'Tổng công ty bưu điện Việt Nam cung cấp bưu chuyển phát nhanh EMS và chuyển phát bưu kiện',
//                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
//            ],
//        ]);
    }
}
