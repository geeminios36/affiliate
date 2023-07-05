<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EcommerceLinkProduct extends Migration
{

    /**
     * Run the migrations.
     *
     * php artisan migrate --path=/database/migrations/2021_09_21_165641_ecommerce_link_product.php
     *
     * Rollback command
     * php artisan migrate:rollback --path=/database/migrations/2021_09_21_165641_ecommerce_link_product.php
     *
     * @return void
     */
    public function up()
    {

        Schema::create('ecommerce_link_products', function (Blueprint $table) {
            $table->increments('id');
            $table->char('tenacy_id');
            $table->integer('ecommerce_market_place_id');
            $table->char('parent_product_market_place_id')->default(0);
            $table->char('product_market_place_id');
            $table->integer('product_stock_id');
            $table->longText('product_detail');
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
        Schema::dropIfExists('ecommerce_link_products');
    }
}
