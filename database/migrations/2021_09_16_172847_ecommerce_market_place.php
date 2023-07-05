<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EcommerceMarketPlace extends Migration
{
    /**
     * Run the migrations.
     *
     * php artisan migrate --path=/database/migrations/2021_09_16_172847_ecommerce_market_place.php
     *
     * Rollback command
     * php artisan migrate:rollback --path=/database/migrations/2021_09_16_172847_ecommerce_market_place.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecommerce_market_places', function (Blueprint $table) {
            $table->increments('id');
            $table->char('tenacy_id');
            $table->char('logo');
            $table->char('market_id')->comment('id gian hàng');
            $table->longText('connection_info')->comment('Thông tin kết nối tời gian hàng');
            $table->longText('token')->comment('Token connect');
            $table->tinyInteger('market_type')->comment('0: shopee, 1: tiki, 2: sen do, 3: lazada');
            $table->tinyInteger('status');
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
        //
        Schema::dropIfExists('ecommerce_market_places');
    }
}
