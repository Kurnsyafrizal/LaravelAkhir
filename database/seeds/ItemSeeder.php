<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_items')->insert([
            [   
                'kode_barang'=>'AA-000000-00A', 
                'nama_barang'=>'TRANSISTOR 54 OHM', 
                'um_id'=>1,
                'created_at'=>Carbon::now() 
            ],
            [
                'kode_barang'=>'AA-000001-00A', 
                'nama_barang'=>'TRANSISTOR 52 OHM', 
                'um_id'=>1,
                'created_at'=>Carbon::now() 
            ]
        ]);
    }
}
