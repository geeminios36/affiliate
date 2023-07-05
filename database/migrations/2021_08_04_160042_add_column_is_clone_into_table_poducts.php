<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Product;
use App\ProductTranslation;
use App\ProductStock;
use App\ProductTax;

class AddColumnIsCloneIntoTablePoducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Product::where('created_at', '>=', '2021-08-21 00:00:00')->delete();
        ProductTranslation::where('created_at', '>=', '2021-08-21 00:00:00')->delete();
        ProductStock::where('created_at', '>=', '2021-08-21 00:00:00')->delete();
        ProductTax::where('created_at', '>=', '2021-08-21 00:00:00')->delete();
        ProductTax::where('created_at', '>=', '2021-08-21 00:00:00')->delete();
    }
}
