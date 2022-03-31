<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stoks')->insert([
            [
                'location_id'=>1, 
                'item_id'=>1, 
                'stored'=>100, 
                'transaction_date'=>Carbon::now(),
                'created_at'=>Carbon::now()
            ],
            [
                'location_id'=>1, 
                'item_id'=>2, 
                'stored'=>80, 
                'transaction_date'=>Carbon::now(),
                'created_at'=>Carbon::now() 
            ],
        ]);
    }
}
