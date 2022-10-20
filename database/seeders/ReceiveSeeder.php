<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReceiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regist = DB::table('registrations')->select('id')->where('period',2020)->inRandomOrder()->limit(600)->get();
        $user   = 'operator@smapluspgri.sch.id';
        foreach ($regist as $r) {
            DB::table('regist_receives')
            ->insert([
                'id_regist'  => $r->id,
                'user'       => $user,
                'created_at' => now()
            ]);
            DB::table('registrations')
            ->where('id',$r->id)
            ->update([
                'status'     => 2,
                'user'       => $user,
                'updated_at' => now()
            ]);
        }
    }
}
