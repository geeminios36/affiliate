<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RemoveTenancyIds extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate --path=database/migrations/2023_08_25_212539_remove_tenancy_ids.php
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('currencies', 'tenacy_id')) {
            Schema::table('currencies', function (Blueprint $table) {
                $table->dropColumn('tenacy_id');
            });
        }
        if (Schema::hasColumn('delivery_partners', 'tenacy_id')) {
            Schema::table('delivery_partners', function (Blueprint $table) {
                $table->dropColumn('tenacy_id');
            });
        }
        if (Schema::hasColumn('news', 'tenacy_id')) {
            Schema::table('news', function (Blueprint $table) {
                $table->dropColumn('tenacy_id');
            });
        }
        if (Schema::hasColumn('seller_package_payments', 'tenacy_id')) {
            Schema::table('seller_package_payments', function (Blueprint $table) {
                $table->dropColumn('tenacy_id');
            });
        }
        if (Schema::hasColumn('seller_package_translations', 'tenacy_id')) {
            Schema::table('seller_package_translations', function (Blueprint $table) {
                $table->dropColumn('tenacy_id');
            });
        }
        if (Schema::hasColumn('manual_payment_methods', 'tenacy_id')) {
            Schema::table('manual_payment_methods', function (Blueprint $table) {
                $table->dropColumn('tenacy_id');
            });
        }
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
