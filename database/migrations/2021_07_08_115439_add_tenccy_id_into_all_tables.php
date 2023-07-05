<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTenccyIdIntoAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables_in_db = \DB::select('SHOW TABLES');
        $db = "Tables_in_".env('DB_DATABASE');
        $tables = [];
        foreach($tables_in_db as $table){
            $table_name = $table->{$db};
            Schema::table($table_name, function (Blueprint $table) {
                $table->string('tenacy_id')->nullable()->default('_tenacy_id_value_default_');
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
        $tables_in_db = \DB::select('SHOW TABLES');
        $db = "Tables_in_".env('DB_DATABASE');
        $tables = [];
        foreach($tables_in_db as $table){
            $table_name = $table->{$db};
            Schema::table($table_name, function (Blueprint $table) use ($table_name) {
                if (Schema::hasColumn($table_name, 'tenacy_id')) {
                    $table->dropColumn('tenacy_id');
                }
            });
        }
    }
}
