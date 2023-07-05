<?php

use App\Http\Traits\DeliveryTenancyTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class Locations extends Migration
{
    /**
     * Run the migrations.
     *
     * php artisan migrate --path=/database/migrations/2021_09_12_160616_locations.php
     *
     * Rollback command
     * php artisan migrate:rollback --path=/database/migrations/2021_09_12_160616_locations.php
     *
     * @return void
     */
    public function up()
    {
        //
        $provinces = json_decode(DeliveryTenancyTrait::getProvinces());
        $provincesFull = json_decode(DeliveryTenancyTrait::getProvinces(true));
        $districtData = collect($provincesFull)->pluck('districts')->flatten();
        $arrayLocation = [];
        $arrayLocationDistrict = [];
        $i = 1;
        foreach ($provinces as $key => $province) {
            $arrayLocation[] = [
                'fullname' => $province->name,
                'parent_id' => 0,
                'code' => $province->code,
                'codename' => $province->codename,
                'division_type' => $province->division_type,
                'phone_code' => $province->phone_code,
            ];
            $parentId = $i++;

            $arrayDistrict = [];
            foreach ($provincesFull[$key]->districts as $district_key => $district) {
                $arrayDistrict[] = [
                    'fullname' => $district->name,
                    'parent_id' => $parentId,
                    'code' => $district->code,
                    'codename' => $district->codename,
                    'division_type' => $district->division_type,
                    'phone_code' => 0,
                ];
            }

            $arrayLocationDistrict[] = $arrayDistrict;
        }

        $arrayLocation = array_merge($arrayLocation, collect($arrayLocationDistrict)->flatten(1)->all());

        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname');
            $table->integer('parent_id');
            $table->string('code');
            $table->string('codename');
            $table->string('division_type');
            $table->integer('phone_code');
            $table->tinyInteger('is_deleted')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        try {
            DB::table('locations')->insert($arrayLocation);

            $districts = DB::table('locations')
                ->where('parent_id', '>', 0)
                ->get();

            $allWards = [];
            foreach ($districts as $key => $district) {
                $wards = collect($districtData)->where('codename', $district->codename)->first();
                $wards = empty($wards) ?  [] : $wards->wards;

                $wardData = [];
                foreach ($wards as $ward){
                    $wardData[] = [
                        'fullname' => $ward->name,
                        'parent_id' => $district->id,
                        'code' => $ward->code,
                        'codename' => $ward->codename,
                        'division_type' => $ward->division_type,
                        'phone_code' => 0,
                    ];
                }

                $allWards[] = $wardData;
            }

            $allWards = collect($allWards)->flatten(1)->all();
            DB::table('locations')->insert($allWards);
        }catch (Exception $exception){
            dd($exception);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
