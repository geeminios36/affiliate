<?php

use Illuminate\Database\Seeder;

class RoleTenacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = \App\Models\Role::where('name', 'like', 'Quản lý xưởng')->first();
        if (empty($role)) {
            \App\Models\Role::insert(
                [
                    'name'        => 'Quản lý xưởng',
                    'permissions' => '["2","3","4","5","6","8","16","20","23"]',
                    'created_at'  => \Carbon\Carbon::now(),
                    'updated_at'  => \Carbon\Carbon::now(),
                    'tenacy_id'   => 'all',
                ]
            );
        }
    }
}
