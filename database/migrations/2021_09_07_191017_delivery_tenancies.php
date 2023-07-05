<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class DeliveryTenancies extends Migration
{
    /**
     * Run the migrations.
     *
     * php artisan migrate --path=/database/migrations/2021_09_07_191017_delivery_tenancies.php
     *
     * Rollback command
     * php artisan migrate:rollback --path=/database/migrations/2021_09_07_191017_delivery_tenancies.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_tenancies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('delivery_partner_id');
            $table->char('tenacy_id');
            $table->char('token_key');
            $table->bigInteger('connect_partner_id');
            $table->tinyInteger('status')->default(0)
                ->comment('0: Chưa kich hoạt; 1: Kích hoạt');;
            $table->tinyInteger('is_deleted')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('delivery_tenancies');
    }
}
