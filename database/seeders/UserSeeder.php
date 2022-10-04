<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'role' => '1',
                'name' => 'Admin',
                'email' => 'admin@smapluspgri.sch.id',
                'password' => Hash::make('123456789'),
                'created_at' => now()
            ],
        ];

        DB::table('users')->insert($users);
    }
}
