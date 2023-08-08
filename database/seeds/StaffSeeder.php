<?php

use App\User;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate()->insert(
            [
                'name' => 'xuonga',
                'email' => 'xuonga@gmail.com',
                'phone' => '0123456789',
                'password' => 'xuonga',
                'role_id' => 0,
            ]
        );
    }
}
