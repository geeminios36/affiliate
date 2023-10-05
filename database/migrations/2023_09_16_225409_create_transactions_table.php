<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * php artisan migrate --path=/database/migrations/2023_09_16_225409_create_transactions_table.php
     *
     * Rollback command
     * php artisan migrate:rollback --path=/database/migrations/2023_09_16_225409_create_transactions_table.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->tinyInteger('user_type');
            $table->integer('wallet_id');
            $table->string('payment_method');
            $table->string('photo', 255)->nullable();
            $table->integer('attribute');
            $table->double('request_amount', 12, 2);
            $table->double('available_balance', 12, 2);
            $table->text('details')->nullable()->default('');
            $table->text('description')->nullable()->default('');
            $table->tinyInteger('status');
            $table->tinyInteger('reject_reason')->nullable();
            $table->timestamps();
            $table->char('tenacy_id', 191);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
