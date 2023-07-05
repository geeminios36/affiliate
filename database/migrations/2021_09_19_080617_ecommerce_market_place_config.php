<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EcommerceMarketPlaceConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * php artisan migrate --path=/database/migrations/2021_09_19_080617_ecommerce_market_place_config.php
     *
     * Rollback command
     * php artisan migrate:rollback --path=/database/migrations/2021_09_19_080617_ecommerce_market_place_config.php
     *
     * @return void
     */
    public function up()
    {

        Schema::create('ecommerce_market_place_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->char('tenacy_id');
            $table->integer('ecommerce_market_place_id');
            $table->string('shorted_name')->comment('Tên rút gọn');
            $table->tinyInteger('use_code_order')->default(1)->comment('Sử dụng mã đơn hàng từ Sàn; 1: true; 0: false');
            $table->tinyInteger('sync_inventory')->default(1)->comment('Tự động đồng bộ tồn kho sản phẩm; 1: true; 0: false');
            $table->tinyInteger('sync_price')->default(1)->comment('Tự động đồng bộ giá sản phẩm; 1: true; 0: false');
            $table->tinyInteger('status_sold')->default(1)->comment('Tự động bật trạng thái sản phẩm “Đang bán” khi tồn kho đồng bộ > 0; 1: true; 0: false');
            $table->tinyInteger('policy_price')->default(0)->comment('Chọn chính sách giá đồng bộ với gian hàng; 0: Giá bán lẻ; 1: Giá nhập; 2: Giá bán buôn');
            $table->char('sync_inventory_branch_to_store')->default(0)->comment('Chi nhánh đồng bộ tồn kho với gian hàng; 0: Tất cả chi nhánh; 1:Chi nhánh mặc định');
            $table->tinyInteger('branch_receives_order')->default(1)->comment('Chi nhánh đồng bộ tồn kho với gian hàng; 1:Chi nhánh mặc định');
            $table->integer('order_officer')->default(0)->comment('Nhân viên phụ trách đơn hàng ');
            $table->tinyInteger('is_deleted')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamp('created_at')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecommerce_market_place_configs');
    }
}
