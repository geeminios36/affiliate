<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTenancyIdUniqueInWallets extends Migration
{
    /**
     * Run the migrations.
     *
     * php artisan migrate --path=database/migrations/2023_10_05_214441_make_tenancy_id_unique_in_wallets.php
     *
     * Rollback command
     * php artisan migrate:rollback --path=/database/migrations/2023_10_05_214441_make_tenancy_id_unique_in_wallets.php
     *
     * @return void
     */
    public function up()
    {
        // Kiểm tra xem bảng wallets có ràng buộc unique cho cột tenancy_id hay chưa
        $hasUnique = Schema::getConnection()
            ->getDoctrineSchemaManager()
            ->listTableDetails('wallets')
            ->hasIndex('tenancy_id_unique');

        if (!$hasUnique) {
            Schema::table('wallets', function (Blueprint $table) {
                $table->unique('tenancy_id');
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
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropUnique('wallets_tenancy_id_unique');
        });
    }
}
