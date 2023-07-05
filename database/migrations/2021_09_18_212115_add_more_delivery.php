<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreDelivery extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate --path=/database/migrations/2021_09_18_212115_add_more_delivery.php
     *
     * @return void
     */
    public function up()
    {
        \App\DeliveryPartners::truncate()->insert([
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
            [
                'fullname' => 'ViettelPost',
                'code' => 'viettelpost',
                'logo' => 'assets/img/delivery/viettel-post.jpg',
                'info' => 'Giải pháp giao hàng, thu hộ chuyên nghiệp với hơn 130 Bưu cục trải dài khắp mọi miền của đất nước.',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'fullname' => 'Best Express',
                'code' => 'bestexpress',
                'logo' => 'assets/img/delivery/best_express.png',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'info' => 'BEST Express được cung cấp bởi Công ty Cổ phần Vinacapital Việt Nam -  Một thành viên của Công ty TNHH BEST LOGISTICS TECHNOLOGY (VIETNAM) ',
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'fullname' => 'DHL',
                'code' => 'dhl',
                'logo' => 'assets/img/delivery/dhl.png',
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'info' => 'Giải pháp giao hàng, thu hộ chuyên nghiệp với hơn 130 Bưu cục trải dài khắp mọi miền của đất nước.',
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
