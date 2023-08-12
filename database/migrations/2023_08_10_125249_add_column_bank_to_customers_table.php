<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBankToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate --path=database/migrations/2023_08_10_125249_add_column_bank_to_customers_table.php
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->text('bank_name')->default('');
            $table->text('bank_acc_no')->default('');
            $table->text('bank_acc_name')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
}
