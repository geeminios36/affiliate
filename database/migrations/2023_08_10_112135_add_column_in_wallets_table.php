<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * php artisan migrate --path=database/migrations/2023_08_10_112135_add_column_in_wallets_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->char('currency')->default('VND');
            $table->double('amount')->default(0)->change();
            $table->tinyInteger('type')->default(4)->comment('1: customer, 2: seller, 3: warehouse, 4: platform');
            $table->tinyInteger('status_withdraw')->default(1)->comment(' 1: có thể rút ít một, 2: chỉ có thể rút toàn bộ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallets', function (Blueprint $table) {
            //
        });
    }
}
