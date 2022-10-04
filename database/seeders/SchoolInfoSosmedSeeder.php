<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolInfoSosmedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schoolinfososmeds = [
            ['id' => 1, 'name' => 'smapluspgri.sch.id', 'url' => 'https://smapluspgri.sch.id', 'icon' => 'cil-newspaper', 'created_at' => now()],
            ['id' => 2, 'name' => 'smapluspgri.info', 'url' => 'https://smapluspgri.info', 'icon' => 'cil-star', 'created_at' => now()],
            ['id' => 3, 'name' => '@smapluspgricibinong', 'url' => 'https://www.instagram.com/smapluspgricibinong/', 'icon' => 'cib-instagram', 'created_at' => now()],
            ['id' => 4, 'name' => 'SMAPLUSPGRICBG', 'url' => 'https://www.facebook.com/SMAPLUSPGRICBG/', 'icon' => 'cib-facebook', 'created_at' => now()],
            ['id' => 5, 'name' => '@SMA_PlusPGRI', 'url' => 'https://twitter.com/sma_pluspgri', 'icon' => 'cib-twitter', 'created_at' => now()],
            ['id' => 6, 'name' => 'SMA PLUS PGRI CIBINONG', 'url' => 'https://www.youtube.com/channel/UCR3cEfdHK7vGtExxXYvpQCw', 'icon' => 'cib-youtube', 'created_at' => now()],
        ];

        DB::table('school_info_sosmeds')->insert($schoolinfososmeds);
    }
}
