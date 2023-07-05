<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeliveryPartners extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate --path=/database/migrations/2021_09_12_193124_delivery_partners.php
     *
     * Rollback command
     * php artisan migrate:rollback --path=/database/migrations/2021_09_12_193124_delivery_partners.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_partners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname');
            $table->string('logo')->unique();
            $table->string('code')->unique();
            $table->string('info');
            $table->tinyInteger('is_deleted')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

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
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_partners');
    }
}
