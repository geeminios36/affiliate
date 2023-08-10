<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollumnPercentCommissionInSellerPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * php artisan migrate --path=database/migrations/2023_08_06_220855_add_collumn_percent_commission_in_seller_packages_table.php
     * 
     * @return void
     */
    public function up()
    {
        Schema::table('seller_packages', function (Blueprint $table) {
            $table->integer('percent_commission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seller_packages', function (Blueprint $table) {
            //
        });
    }
}
