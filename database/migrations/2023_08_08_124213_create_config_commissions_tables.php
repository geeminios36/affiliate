<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigCommissionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * php artisan migrate --path=database/migrations/2023_08_08_124213_create_config_commissions_tables.php
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('config_commissions', function (Blueprint $table) {
            $table->increments('id');
            $table->char('tenacy_id');
            $table->char('name')->default('all');
            $table->integer('seller_commission');
            $table->integer('customer_commission');
            $table->integer('factory_commission');
            $table->integer('remunerate_commission');
            $table->integer('stock_commission');
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
        Schema::dropIfExists('config_commissions');
    }
}
