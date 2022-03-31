<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_locations')->insert([
            [   
                'location' => 'RSMALL',
                'loc_site' => 'HIT KUDUS',
                'create_at' => Carbon::now()
            ]
        ]);
    }
}
