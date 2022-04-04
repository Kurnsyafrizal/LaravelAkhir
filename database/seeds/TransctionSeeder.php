<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TransctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactions')->insert([
            [
                'bukti'=>'TAMBAH01',
                'tgl_transaksi'=>Carbon::now(), 
                'location_id'=>1, 
                'item_id'=>1, 
                'qty'=>100, 
                'program'=>'RECEIPT', 
                'user_id'=>1 ,
                'created_at'=>Carbon::now()
            ],
            [
                'bukti'=>'TAMBAH02',
                'tgl_transaksi'=>Carbon::now(), 
                'location_id'=>1, 
                'item_id'=>2, 
                'qty'=>80, 
                'program'=>'RECEIPT', 
                'user_id'=>1,
                'created_at'=>Carbon::now()
            ],

        ]);
    }
}
