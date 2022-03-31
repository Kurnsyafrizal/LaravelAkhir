<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
                [
                'name'=>'ADITYA', 
                'phone'=>'0822213312', 
                'email'=>'aditya@hit.com', 
                'password'=>Hash::make('adit123') ,
                'created_at'=>Carbon::now()]
        ]);
    }
}
